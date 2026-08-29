<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\{
    HasMiddleware, Middleware
};
use Illuminate\Support\Facades\{
    Validator, Storage, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    BlogCategory,
    Blog, BlogTag
};

class BlogController extends Controller implements HasMiddleware
{
    /**
     * Constructor
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:blog-list', only: ['index']),
            new Middleware('permission:blog-create', only: ['create','store']),
            new Middleware('permission:blog-show', only: ['show']),
            new Middleware('permission:blog-edit', only: ['edit','update','changeStatus']),
            new Middleware('permission:blog-delete', only: ['destroy','bulkDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Blog::with(['category', 'tags']);
            // --------------- Search --------------- //
            if ($request->filled('search')) {

                $search = trim($request->search);

                $query->where(function ($q) use ($search) {

                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");

                });

            }

            // --------------- Category Filter --------------- //
            if ($request->filled('category')) {

                $query->where('blog_category_id', $request->category);

            }

            if ($request->status != '') {

                $query->where('status', $request->status);

            }

            if ($request->featured != '') {

                $query->where('featured', $request->featured);

            }

            if ($request->filled('date_from')) {

                $query->whereDate('published_at', '>=', $request->date_from);

            }

            if ($request->filled('date_to')) {

                $query->whereDate('published_at', '<=', $request->date_to);

            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return view('admin.blogs.partials.checkbox', compact('row'))->render();
                })
                ->editColumn('image', function ($row) {
                    return view('admin.blogs.partials.image', compact('row'))->render();
                })
                ->editColumn('title', function ($row) {
                    return view('admin.blogs.partials.title', compact('row'))->render();
                })
                ->addColumn('tags', function ($row) {
                    return $row->tags
                        ->map(function ($tag) {
                            return '<span class="badge bg-label-primary me-1">'
                                    .$tag->name.
                                '</span>';
                        })
                        ->implode(' ');
                })
                ->addColumn('category', function ($row) {
                    return $row->category?->name ?? '-';
                })
                ->editColumn('featured', function ($row) {
                    return view('admin.blogs.partials.featured', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.blogs.partials.status', compact('row'))->render();
                })
                ->editColumn('published_at', function ($row) {
                    return $row->published_at
                        ? $row->published_at->format('d M Y')
                        : '-';
                })
                ->addColumn('action', function ($row) {
                    return view('admin.blogs.partials.action', compact('row'))->render();
                })
                ->rawColumns([
                    'checkbox',
                    'image',
                    'title',
                    'tags',
                    'featured',
                    'status',
                    'action'
                ])
                ->make(true);
        }
        $categories = BlogCategory::where('status', 1)->orderBy('name')->get();
        $totalBlogs = Blog::count();
        $publishedBlogs = Blog::whereNotNull('published_at')->count();
        $featuredBlogs = Blog::where('featured', 1)->count();
        $inActiveBlogs = Blog::where('status','!=',1)->count();
        return view('admin.blogs.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Blog";

        $tags = BlogTag::active()->ordered()->get();
        $categories = BlogCategory::where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.blogs.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog_category_id' => 'required|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'author' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'published_at' => 'nullable|date',
            'views' => 'nullable|integer|min:0',
            'featured' => 'required|boolean',
            'status' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $image = null;
            if ($request->hasFile('featured_image')) {
                $imageName = time() . '_' . Str::random(8) . '.' .
                    $request->featured_image->getClientOriginalExtension();
                $request->featured_image->move(
                    public_path('images/blogs'),
                    $imageName
                );
                $image = 'images/blogs/' . $imageName;
            }

            $blog = Blog::create([
                'blog_category_id' => $request->blog_category_id,
                'title' => $request->title,
                'slug' => $request->filled('slug')
                    ? Str::slug($request->slug)
                    : Str::slug($request->title),
                'author' => $request->author,
                'featured_image' => $image,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'published_at' => $request->published_at,
                'views' => $request->views ?? 0,
                'featured' => $request->boolean('featured'),
                'status' => $request->boolean('status'),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            $blog->tags()->sync($request->tags ?? []);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Blog created successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($image && Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load('category');
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $title = "Edit Blog";

        $tags = BlogTag::active()->ordered()->get();
        $categories = BlogCategory::where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.blogs.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validator = Validator::make($request->all(), [
            'blog_category_id'   => 'required|exists:blog_categories,id',
            'title'              => 'required|string|max:255',
            'slug'               => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'author'             => 'nullable|string|max:255',
            'featured_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description'  => 'required|string|max:500',
            'description'        => 'required|string',
            'published_at'       => 'nullable|date',
            'views'              => 'nullable|integer|min:0',
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
            //------------- Featured Image -------------//
            if ($request->hasFile('featured_image')) {
                // Delete Old Image
                if (
                    $blog->featured_image &&
                    file_exists(public_path($blog->featured_image))
                ) {
                    unlink(public_path($blog->featured_image));
                }

                // Upload New Image
                $imageName = time() . '_' . Str::random(8) . '.' .
                    $request->featured_image->getClientOriginalExtension();
                $request->featured_image->move(
                    public_path('images/blogs'),$imageName
                );
                $blog->featured_image = 'images/blogs/' . $imageName;
            }

            //------------- Update Blog -------------//
            $blog->blog_category_id = $request->blog_category_id;
            $blog->title = $request->title;
            $blog->slug = $request->filled('slug')
                ? Str::slug($request->slug)
                : Str::slug($request->title);
            $blog->author = $request->author;
            $blog->short_description = $request->short_description;
            $blog->description = $request->description;
            $blog->published_at = $request->published_at;
            $blog->views = $request->views ?? 0;
            $blog->featured = $request->boolean('featured');
            $blog->status = $request->boolean('status');
            $blog->meta_title = $request->meta_title;
            $blog->meta_description = $request->meta_description;
            $blog->save();

            $blog->tags()->sync($request->tags ?? []);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Blog updated successfully.'
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
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        DB::beginTransaction();
        try {
            if (
                $blog->featured_image &&
                file_exists(public_path($blog->featured_image))
            ) {
                unlink(public_path($blog->featured_image));
            }
            $blog->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Blog deleted successfully.'
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
            'ids.*' => 'exists:blogs,id'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);

        }

        DB::beginTransaction();

        try {

            $blogs = Blog::whereIn('id', $request->ids)->get();

            foreach ($blogs as $blog) {

                if (
                    $blog->featured_image &&
                    file_exists(public_path($blog->featured_image))
                ) {

                    unlink(public_path($blog->featured_image));

                }

                $blog->delete();

            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Selected blogs deleted successfully.'
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

            'id' => 'required|exists:blogs,id',

            'status' => 'required|boolean',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);

        }

        $blog = Blog::findOrFail($request->id);

        $blog->status = $request->status;

        $blog->save();

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

            'id' => 'required|exists:blogs,id',

            'featured' => 'required|boolean',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);

        }

        $blog = Blog::findOrFail($request->id);

        $blog->featured = $request->featured;

        $blog->save();

        return response()->json([
            'status' => true,
            'message' => 'Featured status updated successfully.'
        ]);
    }
}
