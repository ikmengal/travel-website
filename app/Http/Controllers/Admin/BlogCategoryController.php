<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\{
    Middleware
};
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        return[
            new Middleware('permission:blog-category-list', only: ['index']),
            new Middleware('permission:blog-category-create', only: ['create', 'store']),
            new Middleware('permission:blog-category-edit', only: ['edit', 'update', 'changeStatus']),
            new Middleware('permission:blog-category-delete', only: ['destroy', 'bulkDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = BlogCategory::query();

            // Search
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Status Filter
            if ($request->status != '') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '
                        <input type="checkbox"
                            class="form-check-input record-checkbox"
                            value="' . $row->id . '">
                    ';
                })
                ->editColumn('name', function ($row) {
                    return '
                        <div>
                            <h6 class="mb-0">' . e($row->name) . '</h6>
                            <small class="text-muted">' . e($row->slug) . '</small>
                        </div>
                    ';
                })
                ->editColumn('description', function ($row) {
                    if (!$row->description) {
                        return '-';
                    }
                    return \Illuminate\Support\Str::limit(strip_tags($row->description), 60);
                })
                ->editColumn('status', function ($row) {
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
                ->editColumn('created_at', function ($row) {
                    return $row->created_at
                        ? $row->created_at->format('d M Y')
                        : '-';
                })
                ->addColumn('action', function ($row) {
                    return view('admin.blog_categories.action', compact('row'))->render();
                })
                ->rawColumns([
                    'checkbox',
                    'name',
                    'status',
                    'action'
                ])
                ->make(true);
        }
        return view('admin.blog_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add Blog Category";
        return view('admin.blog_categories.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
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
            BlogCategory::create([
                'name' => $request->name,
                'slug' => $request->slug
                            ? Str::slug($request->slug)
                            : Str::slug($request->name),
                'description' => $request->description,
                'status' => $request->boolean('status'),
                'sort_order' => $request->sort_order ?? 0,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Blog category created successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory)
    {
        $title = "Blog Category Details";
        return view('admin.blog_categories.show', compact('blogCategory', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $title = "Edit Blog Category";
        return view('admin.blog_categories.edit', compact('blogCategory', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug,' . $blogCategory->id,
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
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
            $blogCategory->update([
                'name' => $request->name,
                'slug' => $request->filled('slug')
                            ? Str::slug($request->slug)
                            : Str::slug($request->name),
                'description' => $request->description,
                'status' => $request->boolean('status'),
                'sort_order' => $request->sort_order ?? 0,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Blog category updated successfully.'
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
    public function destroy(BlogCategory $blogCategory)
    {
        DB::beginTransaction();
        try {
            $blogCategory->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Blog category deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:blog_categories,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $blogCategory = BlogCategory::findOrFail($request->id);
        $blogCategory->update([
            'status' => $request->boolean('status')
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:blog_categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            BlogCategory::whereIn('id', $request->ids)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Selected categories deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
