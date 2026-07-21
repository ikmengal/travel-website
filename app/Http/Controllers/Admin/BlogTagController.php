<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\BlogTag;

class BlogTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $query = BlogTag::with('blogs')->latest();
            $query = BlogTag::withCount('blogs')->latest();


            // ----------------- Search ----------------- //
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
                });
            }

            // ----------------- Filters ----------------- //
            if ($request->status != '') {
                $query->where('status', $request->status);
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
                    return view('admin.blog_tags.partials.checkbox', ['row' => $row])->render();
                })
                ->addColumn('name', function ($row) {
                    return '
                        <div>
                            <strong>'.$row->name.'</strong>
                            <br>
                            <small class="text-muted">
                                '.$row->slug.'
                            </small>
                        </div>
                    ';
                })
                ->addColumn('blogs_count', function ($row) {
                    return '
                        <span class="badge bg-label-primary">
                            '.$row->blogs_count.'
                        </span>
                    ';
                })
                ->addColumn('status', function ($row) {
                    return view('admin.blog_tags.partials.status', ['row' => $row])->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y h:i A');
                })
                ->addColumn('action', function ($row) {
                    return view('admin.blog_tags.action', ['row' => $row])->render();
                })
                ->rawColumns([
                    'checkbox',
                    'name',
                    'blogs_count',
                    'status',
                    'action'
                ])
                ->make(true);
        }
        $blogTag = BlogTag::count();
        $activeBlogTag = BlogTag::where('status', 1)->count();
        $inActiveBlogTag = BlogTag::where('status','!=',1)->count();
        $blogTagCount = BlogTag::withCount('blogs')->count();
        return view('admin.blog_tags.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add Blog Tag";
        return view('admin.blog_tags.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:blog_tags,slug',
            'status'            => 'required|boolean',
            'sort_order'        => 'nullable|integer|min:0',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            BlogTag::create([
                'name'              => $request->name,
                'slug'              => Str::slug($request->slug),
                'status'            => $request->status,
                'sort_order'        => $request->sort_order ?? 0,
                'meta_title'        => $request->meta_title,
                'meta_description'  => $request->meta_description,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Blog tag created successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogTag $blogTag)
    {
        $title = "Blog Tag Details";
        return view('admin.blog_tags.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogTag $blogTag)
    {
        $title = "Edit Blog Tag";
        return view('admin.blog_tags.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogTag $blogTag)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:blog_tags,slug,' . $blogTag->id,
            'status'           => 'required|boolean',
            'sort_order'       => 'nullable|integer|min:0',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $blogTag->update([
                'name'             => $request->name,
                'slug'             => Str::slug($request->slug),
                'status'           => $request->status,
                'sort_order'       => $request->sort_order ?? 0,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Blog tag updated successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogTag $blogTag)
    {
        try {
            // Prevent deletion if tag is assigned to blogs
            if ($blogTag->blogs()->exists()) {
                return response()->json([
                    'message' => 'This tag is assigned to one or more blogs and cannot be deleted.'
                ], 422);
            }

            $blogTag->delete();

            return response()->json([
                'success' => true,
                'message' => 'Blog tag deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
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
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:blog_tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $tags = BlogTag::whereIn('id', $request->ids)->get();
            foreach ($tags as $tag) {
                if ($tag->blogs()->exists()) {
                    continue;
                }
                $tag->delete();
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Selected blog tags deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
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
            'id'     => 'required|exists:blog_tags,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $blogTag = BlogTag::findOrFail($request->id);
            $blogTag->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
