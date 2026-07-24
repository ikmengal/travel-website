<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Storage, DB, Validator
};
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "All Testimonials";
        if ($request->ajax()) {
            $query = Testimonial::query();

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('designation', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('review', 'like', "%{$search}%");
                });
            }

            // --------- Filters --------- //
            if ($request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->featured != '') {
                $query->where('featured', $request->featured);
            }

            if ($request->rating != '') {
                $query->where('rating', $request->rating);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at','>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at','<=', $request->date_to);
            }

            // --------- DataTable --------- //
            return DataTables::of($query)
                ->addColumn('checkbox', function ($row) {
                    return view('admin.testimonials.partials.checkbox', compact('row'))->render();
                })
                ->editColumn('customer', function ($row) {
                    return view('admin.testimonials.partials.user', compact('row'))->render();
                })
                ->editColumn('rating', function ($row) {
                    return str_repeat('⭐', $row->rating);
                })
                ->editColumn('featured', function ($row) {
                    return view('admin.testimonials.partials.featured', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.testimonials.partials.status', compact('row'))->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin.testimonials.action', compact('row'))->render();
                })
                ->rawColumns(['checkbox', 'customer', 'rating', 'featured', 'status', 'action' ])
                ->make(true);
        }
        $cards = [
            'total'      => Testimonial::count(),
            'published'  => Testimonial::where('status',1)->count(),
            'draft'      => Testimonial::where('status',0)->count(),
            'featured'   => Testimonial::where('featured',1)->count(),
            'five_star'  => Testimonial::where('rating',5)->count(),
            'today'      => Testimonial::whereDate('created_at',today())->count(),
        ];
        return view('admin.testimonials.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add Testimonials";
        $countries = Country::get();
        return view('admin.testimonials.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'country_id'        => 'required',
            'state_id'          => 'required',
            'designation'       => 'required|string|max:255',
            'company'           => 'nullable|string|max:255',
            'image'             => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'rating'            => 'required|integer|min:1|max:5',
            'review'            => 'required|string',
            'featured'          => 'required|boolean',
            'status'            => 'required|boolean',
            'sort_order'        => 'nullable|integer|min:0',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/testimonials'), $imageName);
            }

            $testimonial = Testimonial::create([
                'name' => $request->name,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id ?? null,
                'designation' => $request->designation,
                'company' => $request->company,
                'image' => $imageName,
                'rating' => $request->rating,
                'review' => $request->review,
                'featured' => $request->featured,
                'status' => $request->status,
                'sort_order' => $request->sort_order ?? 0,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            DB::commit();
            return redirect()->route('testimonials.index')->with('success', 'Testimonial created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($imageName) && file_exists(public_path('images/testimonials/' . $imageName))) {
                unlink(public_path('images/testimonials/' . $imageName));
            }
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        $title = "Testimonial Details";
        return view('admin.testimonials.show', compact(['testimonial', 'title']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        $title = "Edit Testimonial";
        $countries = Country::get();
        return view('admin.testimonials.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validate = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'country_id'        => 'required',
            'state_id'          => 'required',
            'designation'       => 'required|string|max:255',
            'company'           => 'nullable|string|max:255',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'rating'            => 'required|integer|min:1|max:5',
            'review'            => 'required|string',
            'featured'          => 'required|boolean',
            'status'            => 'required|boolean',
            'sort_order'        => 'nullable|integer|min:0',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
        ]);

        if ($validate->fails()) {
            return redirect()
                ->back()
                ->withErrors($validate)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $imageName = $testimonial->image;
            if ($request->hasFile('image')) {
                // Delete old image
                if (
                    $testimonial->image &&
                    file_exists(public_path('images/testimonials/' . $testimonial->image))
                ) {
                    unlink(public_path('images/testimonials/' . $testimonial->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/testimonials'), $imageName);
            }

            $testimonial->update([
                'name' => $request->name,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id ?? null,
                'designation' => $request->designation,
                'company' => $request->company,
                'image' => $imageName,
                'rating' => $request->rating,
                'review' => $request->review,
                'featured' =>  $request->boolean('status'),
                'status' =>  $request->boolean('status'),
                'sort_order' => $request->sort_order ?? 0,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            DB::commit();
            return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        DB::beginTransaction();
        try {
            if (
                $testimonial->image &&
                file_exists(public_path('images/testimonials/' . $testimonial->image))
            ) {
                unlink(public_path('images/testimonials/' . $testimonial->image));
            }

            $testimonial->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Testimonial deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

     /**
     * Change Status (AJAX)
     */
    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:testimonials,id',
            'status' => 'required|boolean',
        ]);

        $testimonial = Testimonial::findOrFail($request->id);
        $testimonial->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    /**
     * Change Featured (AJAX)
     */
    public function changeFeatured(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:testimonials,id'],
            'featured' => ['required', 'boolean'],
        ]);

        try {

            $testimonial = Testimonial::findOrFail($request->id);

            $testimonial->update([
                'featured' => $request->boolean('featured'),
            ]);

            return response()->json([
                'status' => true,
                'message' => $testimonial->featured
                    ? 'Testimonial marked as featured successfully.'
                    : 'Testimonial removed from featured successfully.',
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Failed to update featured status.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);

        }
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:testimonials,id',
        ]);

        DB::beginTransaction();
        try {
            $testimonials = Testimonial::whereIn('id', $request->ids)->get();
            foreach ($testimonials as $testimonial) {
                if (
                    $testimonial->image &&
                    file_exists(public_path('images/testimonials/' . $testimonial->image))
                ) {
                    unlink(public_path('images/testimonials/' . $testimonial->image));
                }
                $testimonial->delete();
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Selected testimonials deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk Delete
     */
    public function getState(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $states = State::where('country_id', $request->id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Selected testimonials deleted successfully.',
                'data' => $states
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk Delete
     */
    public function getCity(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $cities = City::where('state_id', $request->id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Selected testimonials deleted successfully.',
                'data' => $cities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
