<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, File, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    TourCategory,
    Destination,
    Country,
    Tour
};

class TourCountroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = Tour::with(['destination', 'category']);

            // -------------- Filters -------------- //
            if ($request->filled('destination')) {
                $query->where('destination_id', $request->destination);
            }

            if ($request->filled('category')) {
                $query->where('tour_category_id', $request->category);
            }

            if ($request->status !== null && $request->status !== '') {
                $query->where('status', $request->status);
            }

            if ($request->featured !== null && $request->featured !== '') {
                $query->where('featured', $request->featured);
            }

            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('tour_code', 'like', "%{$search}%")
                        ->orWhere('tagline', 'like', "%{$search}%")
                        ->orWhereHas('destination', function ($d) use ($search) {
                            $d->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($c) use ($search) {
                            $c->where('name', 'like', "%{$search}%");
                        });
                });
            }

            return DataTables::of($query)
                ->addColumn('checkbox', function ($row) {
                    return '
                        <input type="checkbox" class="form-check-input row-checkbox" value="' . $row->id . '">
                    ';
                })
                ->addColumn('image', function ($row) {
                    $image = $row->featured_image
                        ? asset($row->featured_image)
                        : asset('admin/assets/img/illustrations/placeholder.jpg');
                    return '<img src="' . $image . '" class="rounded shadow-sm border" style=" width:75px; height:60px; object-fit:cover;">
                    ';
                })
                ->addColumn('tour', function ($row) {
                    return '
                        <div>
                            <h6 class="mb-0 fw-semibold">'
                                . e($row->title) .
                            '</h6>

                            <small class="text-muted">
                                Code :
                                <span class="badge bg-label-dark">
                                    ' . e($row->tour_code) . '
                                </span>
                            </small>
                        </div>
                    ';
                })
                ->addColumn('destination', function ($row) {
                    return $row->destination
                        ? '<span class="badge bg-label-primary">'
                            . e($row->destination->name) .
                        '</span>'
                        : '-';
                })
                ->addColumn('category', function ($row) {
                    return $row->category
                        ? '<span class="badge bg-label-info">'
                            . e($row->category->name) .
                        '</span>'
                        : '-';
                })
                ->addColumn('price', function ($row) {
                    $html = '<div>';
                    if ($row->discount_price) {
                        $html .= '
                            <h6 class="mb-0 text-success">
                                $' . number_format($row->discount_price,2) . '
                            </h6>
                            <small class="text-decoration-line-through text-muted">
                                $' . number_format($row->price,2) . '
                            </small>
                        ';
                    } else {
                        $html .= '
                            <h6 class="mb-0">
                                $' . number_format($row->price,2) . '
                            </h6>
                        ';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('duration', function ($row) {
                    return '
                        <span class="badge bg-label-warning me-1">
                            ' . $row->duration_days . 'D
                        </span>
                        <span class="badge bg-label-secondary">
                            ' . $row->duration_nights . 'N
                        </span>
                    ';
                })
                ->addColumn('rating', function ($row) {
                    return '
                        <span class="text-warning">
                            ★
                        </span>
                        ' . number_format($row->rating,1) . '
                        <br>
                        <small class="text-muted">
                            ' . $row->reviews_count . ' Reviews
                        </small>
                    ';
                })
                ->addColumn('featured', function ($row) {
                    $checked = $row->featured ? 'checked' : '';
                    return '
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                class="form-check-input changeFeatured"
                                data-id="' . $row->id . '"
                                ' . $checked . '>
                        </div>
                    ';
                })
                ->addColumn('popular', function ($row) {
                    $checked = $row->popular ? 'checked' : '';
                    return '
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                class="form-check-input changePopular"
                                data-id="' . $row->id . '"
                                ' . $checked . '>
                        </div>
                    ';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                class="form-check-input changeStatus"
                                data-id="' . $row->id . '"
                                ' . $checked . '>
                        </div>
                    ';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->addColumn('action', function ($row) {
                    return view('admin.tours.action', compact('row'))->render();
                })
                ->rawColumns([
                    'checkbox',
                    'image',
                    'tour',
                    'destination',
                    'category',
                    'price',
                    'duration',
                    'rating',
                    'featured',
                    'popular',
                    'status',
                    'action',
                ])
                ->make(true);
        }
        $data = [
            'title'           => 'Tours',
            'destinations'    => Destination::where('status', 1)->orderBy('name')->get(),
            'categories'      => TourCategory::where('status', 1)->orderBy('name')->get(),
            'totalTours'      => Tour::count(),
            'featuredTours'   => Tour::where('featured', 1)->count(),
            'popularTours'    => Tour::where('popular', 1)->count(),
            'activeTours'     => Tour::where('status', 1)->count(),
        ];
        return view('admin.tours.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Tour";
        $destinations = Destination::whereStatus(1)->orderBy('name')->get();
        $categories = TourCategory::whereStatus(1)->orderBy('name')->get();
        return view('admin.tours.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->authorize('tours-craete');
        $validator = Validator::make($request->all(), [
            'destination_id'      => 'required|exists:destinations,id',
            'tour_category_id'    => 'nullable|exists:tour_categories,id',

            'title'               => 'required|string|max:255',
            'tour_code'           => 'required|string|max:100|unique:tours,tour_code',
            'tagline'             => 'nullable|string|max:255',

            'short_description'   => 'nullable|string',
            'description'         => 'nullable|string',

            'price'               => 'required|numeric|min:0',
            'discount_price'      => 'nullable|numeric|lte:price',

            'duration_days'       => 'required|integer|min:1',
            'duration_nights'     => 'required|integer|min:0',

            'max_people'          => 'nullable|integer|min:1',
            'min_age'             => 'nullable|integer|min:0',

            'featured_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string',

            'featured'            => 'nullable',
            'popular'             => 'nullable',
            'status'              => 'nullable',
            'sort_order'          => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $tour = new Tour();

            $tour->destination_id      = $request->destination_id;
            $tour->tour_category_id    = $request->tour_category_id;

            $tour->title               = $request->title;
            $tour->slug                = Str::slug($request->title);

            // ---------- Unique Slug ----------
            $count = Tour::where('slug', $tour->slug)->count();
            if ($count > 0) {
                $tour->slug .= '-' . ($count + 1);
            }

            $tour->tour_code           = $request->tour_code;
            $tour->tagline             = $request->tagline;

            $tour->short_description   = $request->short_description;
            $tour->description         = $request->description;

            $tour->price               = $request->price;
            $tour->discount_price      = $request->discount_price;

            $tour->duration_days       = $request->duration_days;
            $tour->duration_nights     = $request->duration_nights;

            $tour->max_people          = $request->max_people ?? 1;
            $tour->min_age             = $request->min_age;

            $tour->rating              = 0;
            $tour->reviews_count       = 0;

            $tour->featured            = $request->filled('featured');
            $tour->popular             = $request->filled('popular');
            $tour->status              = $request->filled('status');

            $tour->sort_order          = $request->sort_order ?? 0;

            $tour->meta_title          = $request->meta_title;
            $tour->meta_description    = $request->meta_description;

            // ===============================
            // Featured Image Upload
            // ===============================

            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/tours'), $imageName);
                $tour->featured_image = 'images/tours/' . $imageName;
            }

            $tour->save();

            DB::commit();
            return redirect()->route('tours.index')->with('success', 'Tour created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tour $tour)
    {
        $tour->load(['destination','category','images','itineraries','includes','excludes','departures',]);
        $title = 'Tour Details';
        return view('admin.tours.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tour $tour)
    {
        $title = 'Edit Tour';

        $destinations = Destination::where('status', 1)
            ->orderBy('name')
            ->get();

        $categories = TourCategory::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.tours.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tour $tour)
    {
        $validator = Validator::make($request->all(), [
            'destination_id'      => 'required|exists:destinations,id',
            'tour_category_id'    => 'nullable|exists:tour_categories,id',

            'title'               => 'required|max:255',

            'tour_code'           => 'required|unique:tours,tour_code,' . $tour->id,

            'price'               => 'required|numeric|min:0',

            'discount_price'      => 'nullable|numeric|lte:price',

            'duration_days'       => 'required|integer|min:1',

            'duration_nights'     => 'required|integer|min:0',

            'max_people'          => 'nullable|integer|min:1',

            'min_age'             => 'nullable|integer|min:0',

            'featured_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'meta_title'          => 'nullable|max:255',

            'meta_description'    => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $tour->destination_id      = $request->destination_id;
            $tour->tour_category_id    = $request->tour_category_id;

            $tour->title               = $request->title;

            $slug = Str::slug($request->title);

            if (
                Tour::where('slug', $slug)
                    ->where('id', '!=', $tour->id)
                    ->exists()
            ) {
                $slug .= '-' . time();
            }

            $tour->slug                = $slug;

            $tour->tour_code           = $request->tour_code;

            $tour->tagline             = $request->tagline;

            $tour->short_description   = $request->short_description;

            $tour->description         = $request->description;

            $tour->price               = $request->price;

            $tour->discount_price      = $request->discount_price;

            $tour->duration_days       = $request->duration_days;

            $tour->duration_nights     = $request->duration_nights;

            $tour->max_people          = $request->max_people;

            $tour->min_age             = $request->min_age;

            $tour->featured            = $request->filled('featured');

            $tour->popular             = $request->filled('popular');

            $tour->status              = $request->filled('status');

            $tour->sort_order          = $request->sort_order ?? 0;

            $tour->meta_title          = $request->meta_title;

            $tour->meta_description    = $request->meta_description;

            // ===========================
            // Featured Image
            // ===========================

            if ($request->hasFile('featured_image')) {

                if (
                    $tour->featured_image &&
                    file_exists(public_path($tour->featured_image))
                ) {
                    unlink(public_path($tour->featured_image));
                }

                $image = $request->file('featured_image');

                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('images/tours'), $imageName);

                $tour->featured_image = 'images/tours/' . $imageName;
            }

            $tour->save();

            DB::commit();
            return redirect()->route('tours.index')->with('success', 'Tour updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour)
    {
        try {
            if ($tour->featured_image && file_exists(public_path($tour->featured_image))) {
                unlink(public_path($tour->featured_image));
            }

            $tour->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Tour deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        Tour::whereIn('id', $request->ids)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Selected tours deleted successfully.'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $tour = Tour::findOrFail($request->id);

        $tour->status = !$tour->status;

        $tour->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    public function changeFeatured(Request $request)
    {
        $tour = Tour::findOrFail($request->id);

        $tour->featured = !$tour->featured;

        $tour->save();

        return response()->json([
            'status' => true,
            'message' => 'Featured updated successfully.'
        ]);
    }

    public function changePopular(Request $request)
    {
        $tour = Tour::findOrFail($request->id);

        $tour->popular = !$tour->popular;

        $tour->save();

        return response()->json([
            'status' => true,
            'message' => 'Popular updated successfully.'
        ]);
    }
}
