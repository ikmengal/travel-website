<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB, File
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display listing.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Page::query();
            // ----------------- Search ----------------- //
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('slug', 'like', '%' . $request->search . '%');
                });
            }
            if ($request->filled('page_type')) {
                $query->where('page_type', $request->page_type);
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
                    return view('admin.pages.partials.checkbox', ['row' => $row])->render();
                })
                ->addColumn('image', function ($row) {
                    return '<img src="' . $row->image . '" width="60" height="60" class="rounded object-fit-cover border">';
                })
                ->editColumn('title', function ($row) {
                    return '
                        <strong>' . e($row->title) . '</strong>
                        <br>
                        <small class="text-muted">' . e($row->slug) . '</small>
                    ';
                })
                ->addColumn('page_type', function ($row) {
                    return '<span class="badge bg-label-info">' . Page::PAGE_TYPES[$row->page_type] . '</span>';
                })
                ->addColumn('featured', function ($row) {
                    return view('admin.components.switch-featured',[
                        'id'=>$row->id,
                        'checked'=>$row->featured,
                        'class'=>'changeFeatured'
                    ])->render();
                })
                ->addColumn('status', function ($row) {
                    return view('admin.components.switch-status', [
                        'id'=>$row->id,
                        'checked'=>$row->status,
                        'class'=>'changeStatus'
                    ])->render();
                })
                ->editColumn('sort_order', function ($row) {
                    return '<span class="badge bg-label-primary">' .$row->sort_order. '</span>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->addColumn('action', function ($row) {
                    return view('admin.pages.action', ['row' => $row])->render();
                })
                ->rawColumns([
                    'checkbox',
                    'image',
                    'title',
                    'page_type',
                    'featured',
                    'status',
                    'sort_order',
                    'action',
                ])
                ->make(true);
        }
        return view('admin.pages.index');
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $title = "Craete Pages";
        return view('admin.pages.create', get_defined_vars());
    }

    /**
     * Store page.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'page_type' => 'required|in:' . implode(',', array_keys(Page::PAGE_TYPES)),

            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'short_description' => 'nullable|string',
            'description' => 'required|string',

            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',

            'sort_order' => 'nullable|integer|min:0',

            'featured' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $page = new Page();
            $page->title = $request->title;
            $page->slug = Str::slug($request->slug);
            $page->page_type = $request->page_type;
            $page->short_description = $request->short_description;
            $page->description = $request->description;
            $page->meta_title = $request->meta_title;
            $page->meta_keywords = $request->meta_keywords;
            $page->meta_description = $request->meta_description;
            $page->sort_order = $request->sort_order ?? 0;
            $page->featured = $request->featured;
            $page->status = $request->status;

            // Featured Image
            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $imageName = time().'_featured_'.Str::random(8).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/pages'),$imageName);
                $page->featured_image = $imageName;
            }

            // Thumbnail Image
            if ($request->hasFile('thumbnail_image')) {
                $image = $request->file('thumbnail_image');
                $imageName = time().'_thumb_'.Str::random(8).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/pages'),$imageName);
                $page->thumbnail_image = $imageName;
            }

            $page->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('images/pages/gallery'),$imageName);
                    $page->images()->create([
                        'image'=>$imageName
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Page created successfully.'
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
     * Show page.
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Edit page.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update page.
     */
    public function update(Request $request, Page $page)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'page_type' => 'required|in:' . implode(',', array_keys(Page::PAGE_TYPES)),
            'featured_image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'thumbnail_image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'images.*'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'short_description' => 'nullable|string',
            'description' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'featured' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $page->title = $request->title;
            $page->slug = Str::slug($request->slug);
            $page->page_type = $request->page_type;
            $page->short_description = $request->short_description;
            $page->description = $request->description;
            $page->meta_title = $request->meta_title;
            $page->meta_keywords = $request->meta_keywords;
            $page->meta_description = $request->meta_description;
            $page->sort_order = $request->sort_order ?? 0;
            $page->featured = $request->featured;
            $page->status = $request->status;

            // ---------------- Replace featured image ---------------- //
            if($request->hasFile('featured_image')){
                if($page->featured_image && File::exists(public_path('images/pages/'.$page->featured_image))){
                    File::delete(public_path('images/pages/'.$page->featured_image));
                }

                $image=$request->file('featured_image');
                $imageName=time().'_featured_'.Str::random(8).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/pages'),$imageName);
                $page->featured_image=$imageName;
            }

            // ---------------- Replace thumbnail image ---------------- //
            if($request->hasFile('thumbnail_image')){
                if($page->thumbnail_image && File::exists(public_path('images/pages/'.$page->thumbnail_image))){
                    File::delete(public_path('images/pages/'.$page->thumbnail_image));
                }

                $image=$request->file('thumbnail_image');
                $imageName=time().'_thumb_'.Str::random(8).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/pages'),$imageName);
                $page->thumbnail_image=$imageName;
            }

            $page->save();

            if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                    $imageName=time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('images/pages/gallery'),$imageName);
                    $page->images()->create([
                        'image'=>$imageName
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Page updated successfully.'
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
     * Delete page.
     */
    public function destroy(Page $page)
    {
        DB::beginTransaction();

        try {

            if (
                $page->featured_image &&
                File::exists(public_path('images/pages/' . $page->featured_image))
            ) {
                File::delete(public_path('images/pages/' . $page->featured_image));
            }

            $page->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Page deleted successfully.'
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
     * Bulk Delete.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:pages,id',
        ]);

        DB::beginTransaction();

        try {

            $pages = Page::whereIn('id', $request->ids)->get();

            foreach ($pages as $page) {

                if (
                    $page->featured_image &&
                    File::exists(public_path('images/pages/' . $page->featured_image))
                ) {
                    File::delete(public_path('images/pages/' . $page->featured_image));
                }

                $page->delete();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Selected pages deleted successfully.'
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
     * Change Status.
     */
    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pages,id',
            'status' => 'required|boolean',
        ]);

        $page = Page::findOrFail($request->id);

        $page->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Page status updated successfully.'
        ]);
    }

    /**
     * Change Featured.
     */
    public function changeFeatured(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pages,id',
            'featured' => 'required|boolean',
        ]);

        $page = Page::findOrFail($request->id);

        $page->update([
            'featured' => $request->featured
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Page featured status updated successfully.'
        ]);
    }
}
