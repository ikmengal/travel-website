<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Banner::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('subtitle', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->featured != '') {
            $query->where('featured', $request->featured);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return view('admin.banners.partials.checkbox', ['row' => $row])->render();
            })
            ->addColumn('image', function ($row) {
                return view('admin.banners.partials.image', ['row' => $row])->render();
            })
            ->editColumn('title', function ($row) {
                return '
                    <strong>'.$row->title.'</strong>
                    <br>
                    <small class="text-muted">'.Str::limit(strip_tags($row->subtitle), 25).'</small>
                ';
            })
            ->addColumn('featured', function ($row) {
                return view('admin.banners.partials.featured', ['row' => $row])->render();
            })
            ->addColumn('status', function ($row) {
                return view('admin.banners.partials.status', ['row' => $row])->render();
            })
            ->editColumn('sort_order', function ($row) {
                return '<span class="badge bg-label-info">'
                        .$row->sort_order.
                        '</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.banners.action', ['row' => $row])->render();
            })
            ->rawColumns([
                'checkbox',
                'image',
                'title',
                'featured',
                'status',
                'sort_order',
                'action',
            ])
            ->make(true);
        }

        $banners = Banner::count();
        $activeBanner = Banner::where('status', 1)->count();
        $featuredBanner = Banner::where('featured',1)->count();
        $inactiveBanner = Banner::where('status','!=',1)->count();
        return view('admin.banners.index', get_defined_vars());
    }

    /**
     * Show the form for creating.
     */
    public function create()
    {
        $title = "Add Banner";
        return view('admin.banners.create', get_defined_vars());
    }

    /**
     * Store resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured' => 'required|boolean',
            'status' => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ],422);
        }

        try {
            $data = $request->except('image');

            $data['featured'] = $request->featured ?? 0;
            $data['status'] = $request->status ?? 0;
            $data['sort_order'] = $request->sort_order ?? 0;
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'_'.$image->getClientOriginalName();
                $image->move(
                    public_path('images/banners'),
                    $imageName
                );
                $data['image'] = $imageName;
            }

            $banner = Banner::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Banner created successfully',
                'data' => $banner
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Display resource.
     */
    public function show(Banner $banner)
    {
        $title = "Banner Details";
        return view('admin.banners.show', get_defined_vars());
    }

    /**
     * Show edit form.
     */
    public function edit(Banner $banner)
    {
        $title = "Edit Banners";
        return view('admin.banners.edit', get_defined_vars());
    }

    /**
     * Update resource.
     */
    public function update(Request $request, Banner $banner)
    {
        $validator = Validator::make($request->all(), [
            'title'              => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:255',
            'description'        => 'required|string',
            'button_text'        => 'nullable|string|max:100',
            'button_url'         => 'nullable|url|max:255',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order'         => 'nullable|integer|min:0',
            'featured'           => 'required|boolean',
            'status'             => 'required|boolean',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            //------------- Image -------------//
            if ($request->hasFile('image')) {
                // Delete Old Image
                if (
                    $banner->image &&
                    file_exists(public_path('images/banners/'.$banner->image))
                ) {
                    unlink(public_path('images/banners/'.$banner->image));
                }

                // Upload New Image
                $imageName = time() . '_' . Str::random(8) . '.' .
                    $request->image->getClientOriginalExtension();
                $request->image->move(
                    public_path('images/banners'),$imageName
                );
                $banner->image = $imageName;
            }

            //------------- Update Banner -------------//
            $banner->title = $request->title;
            $banner->subtitle = $request->subtitle;
            $banner->description = $request->description;
            $banner->button_text = $request->button_text;
            $banner->button_url = $request->button_url;
            $banner->featured = $request->boolean('featured');
            $banner->status = $request->boolean('status');
            $banner->sort_order = $request->sort_order;
            $banner->meta_title = $request->meta_title;
            $banner->meta_description = $request->meta_description;
            $banner->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Banner updated successfully.'
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
     * Delete resource.
     */
    public function destroy(Banner $banner)
    {
        DB::beginTransaction();
        try {
            if ($banner->image && file_exists(public_path('images/banners/'.$banner->image)))
            {
                unlink(public_path('images/banners/'.$banner->image));
            }
            $banner->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Banner deleted successfully.'
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
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:banners,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $banners = Banner::whereIn('id', $request->ids)->get();

            foreach ($banners as $banner) {
                if ($banner->image && file_exists(public_path('images/banners/'.$banner->image))) {
                    unlink(public_path('images/banners/'.$banner->image));
                }
                $banner->delete();
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Selected banners deleted successfully.'
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
     * Change Status
     */
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:banners,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = Banner::findOrFail($request->id);
        $banner->status = $request->status;
        $banner->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    /**
     * Change Featured
     */
    public function changeFeatured(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:banners,id',
            'featured' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = Banner::findOrFail($request->id);
        $banner->featured = $request->featured;
        $banner->save();

        return response()->json([
            'status' => true,
            'message' => 'Featured status updated successfully.'
        ]);
    }
}
