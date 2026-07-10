<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB, Log
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    Destination,
    Tour, Hotel,
    User, Car,
    Booking,
    Review,
    Flight
};

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = Review::with([
                'user',
                'reviewable'
            ]);

            // ------------ FILTER ------------ //
            if ($request->filled('reviewable_type')) {
                $query->where('reviewable_type', $request->reviewable_type);
            }

            if ($request->filled('reviewable_id')) {
                $query->where('reviewable_id', $request->reviewable_id);
            }

            if ($request->filled('rating')) {
                $query->where('rating', $request->rating);
            }

            if ($request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->verified != '') {
                $query->where('is_verified', $request->verified);
            }

            if ($request->featured != '') {
                $query->where('is_featured', $request->featured);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use($search){
                    $q->where('title','LIKE',"%{$search}%")
                    ->orWhere('review','LIKE',"%{$search}%");
                });
            }

            return DataTables::of($query->latest())
            ->addIndexColumn()
            ->addColumn('checkbox',function($row){
                return '
                <input type="checkbox"
                class="form-check-input row-checkbox"
                value="'.$row->id.'">';
            })
            ->addColumn('type',function($row){
                return '
                <span class="badge bg-label-primary">
                '.class_basename($row->reviewable_type).'
                </span>';
            })
            ->addColumn('related',function($row){
                if(!$row->reviewable){
                    return '-';
                }
                return $row->reviewable->title ?? $row->reviewable->name ?? '-';
            })
            ->addColumn('user',function($row){
                return $row->user->name ?? '-';
            })
            ->addColumn('rating',function($row){
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $row->rating) {
                        $stars .= '<i class="ti ti-star text-warning"></i>';
                    } else {
                        $stars .= '<i class="ti ti-star text-muted"></i>';
                    }
                }
                return $stars;
            })
            ->addColumn('verified',function($row){
                $checked = $row->is_verified ? 'checked':'';
                return '
                    <div class="form-check form-switch">
                    <input type="checkbox"
                    class="form-check-input changeVerified"
                    data-id="'.$row->id.'"
                '.$checked.'>
                </div>';
            })
            ->addColumn('featured',function($row){
                $checked = $row->is_featured ? 'checked':'';
                return '
                    <div class="form-check form-switch">
                    <input type="checkbox"
                    class="form-check-input changeFeatured"
                    data-id="'.$row->id.'"
                '.$checked.'>
                </div>';
            })
            ->addColumn('status',function($row){
                $checked = $row->status ? 'checked':'';
                    return '
                    <div class="form-check form-switch">
                    <input type="checkbox"
                    class="form-check-input changeStatus"
                    data-id="'.$row->id.'"
                    '.$checked.'>
                </div>';
            })
            ->editColumn('created_at',function($row){
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action',function($row){
                return view('admin.reviews.action',compact('row'));
            })
            ->rawColumns(['checkbox', 'type', 'rating', 'verified', 'featured', 'status', 'action'])
            ->make(true);
        }

        $title = "Review Management";
        $totalReviews = Review::count();
        $approvedReviews = Review::where('status', 1)->count();
        $pendingReviews = Review::where('status', 0)->count();
        $featuredReviews = Review::where('is_featured', 1)->count();
        $verifiedReviews = Review::where('is_verified', 1)->count();
        $averageRating = Review::avg('rating') ?? 0;
        return view('admin.reviews.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Review';
        $users = User::where('status',1)->get();
        $bookings = Booking::get();

        return view('admin.reviews.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'          => 'required|exists:users,id',
            'reviewable_type'  => 'required|string',
            'reviewable_id'    => 'required|integer',
            'rating'           => 'required|integer|min:1|max:5',
            'title'            => 'nullable|string|max:255',
            'review'           => 'required|string',
            'pros'             => 'nullable|string',
            'cons'             => 'nullable|string',
            'booking_id'       => 'nullable|exists:bookings,id',
            'is_verified'      => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'status'           => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $models = [
                Destination::class => Destination::class,
                Booking::class     => Booking::class,
                Flight::class      => Flight::class,
                Hotel::class       => Hotel::class,
                Tour::class        => Tour::class,
                Car::class         => Car::class,
                // TourPackage::class => TourPackage::class,
            ];

            if(!array_key_exists($request->reviewable_type, $models)){
                return redirect()->back()->withInput()->with('error', 'Invalid Review Type.');
            }

            $model = $models[$request->reviewable_type];
            $record = $model::find($request->reviewable_id);

            if(!$record){
                return redirect()->back()->withInput()->with('error', 'Selected record not found.');
            }

            Review::create([
                'user_id' => $request->user_id,
                'booking_id' => $request->booking_id,
                'reviewable_type' => $request->reviewable_type,
                'reviewable_id' => $request->reviewable_id,
                'rating' => $request->rating,
                'title' => $request->title,
                'review' => $request->review,
                'pros' => $request->pros,
                'cons' => $request->cons,
                'is_verified' => $request->boolean('is_verified'),
                'is_featured' => $request->boolean('is_featured'),
                'status' => $request->boolean('status',true),
            ]);

            DB::commit();
            return redirect()->route('reviews.index')->with('success', 'Review created successfully.');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $title = 'Review Details';
        $review->load(['user','booking','reviewable']);
        return view('admin.reviews.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        $title = 'Edit Review';
        $review->load(['user','reviewable','booking']);
        $users = User::where('status',1)->get();
        $bookings = Booking::get();
        return view('admin.reviews.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $validator = Validator::make($request->all(), [
            'user_id'          => 'required|exists:users,id',
            'reviewable_type'  => 'required|string',
            'reviewable_id'    => 'required|integer',
            'rating'           => 'required|integer|min:1|max:5',
            'title'            => 'nullable|string|max:255',
            'review'           => 'required|string',
            'pros'             => 'nullable|string',
            'cons'             => 'nullable|string',
            'booking_id'       => 'nullable|exists:bookings,id',
            'is_verified'      => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'status'           => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $models = [
                Tour::class        => Tour::class,
                Hotel::class       => Hotel::class,
                Destination::class => Destination::class,
                Car::class         => Car::class,
                Flight::class      => Flight::class,
            ];

            if(!array_key_exists($request->reviewable_type, $models)){
                return redirect()->back()->withInput()->with('error', 'Invalid Review Type.');
            }

            $model = $models[$request->reviewable_type];
            $record = $model::find($request->reviewable_id);

            if(!$record){
                return redirect()->back()->withInput()->with('error', 'Selected record not found.');
            }

            $review->update([
                'user_id' => $request->user_id,
                'booking_id' => $request->booking_id,
                'reviewable_type' => $request->reviewable_type,
                'reviewable_id' => $request->reviewable_id,
                'rating' => $request->rating,
                'title' => $request->title,
                'review' => $request->review,
                'pros' => $request->pros,
                'cons' => $request->cons,
                'is_verified' => $request->boolean('is_verified'),
                'is_featured' => $request->boolean('is_featured'),
                'approved_at' => $request->boolean('status') ? $request->approved_at : null,
                'status' => $request->boolean('status', true),
            ]);

            DB::commit();
            return redirect()->route('reviews.index')->with('success','Review updated successfully.');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        DB::beginTransaction();

        try {
            $review->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Review deleted successfully.'
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Change Review Status
     */
    public function changeVerified(Request $request)
    {
        try {
            $review = Review::findOrFail($request->id);
            $review->is_verified = !$review->is_verified;
            $review->save();

            return response()->json([
                'status'  => true,
                'message' => 'Verified updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change Review Status
     */
    public function changeStatus(Request $request)
    {
        try {
            $review = Review::findOrFail($request->id);
            $review->status = !$review->status;
            $review->save();

            return response()->json([
                'status'  => true,
                'message' => 'Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change Featured Status
     */
    public function changeFeatured(Request $request)
    {
        try {
            $review = Review::findOrFail($request->id);
            $review->is_featured = !$review->is_featured;
            $review->save();

            return response()->json([
                'status'  => true,
                'message' => 'Featured status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        try {
            if (!$request->filled('ids')) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please select at least one FAQ.'
                ]);
            }

            Review::whereIn('id', $request->ids)->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Selected Reviews deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Models By Type (AJAX)
     */
    public function getModels(Request $request)
    {
        $models = [
            Tour::class => Tour::select('id', 'title')->orderBy('title')->get(),
            Hotel::class => Hotel::select('id', 'name')->orderBy('name')->get(),
            Destination::class => Destination::select('id', 'name')->orderBy('name')->get(),
            Car::class => Car::select('id', 'name')->orderBy('name')->get(),
            // Flight::class => Flight::select('id', 'title')->orderBy('title')->get(),
            // TourPackage::class => TourPackage::select('id', 'title')->orderBy('title')->get(),
        ];

        return response()->json(
            $models[$request->type] ?? []
        );
    }
}
