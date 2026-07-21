<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    BlogComment,
    Blog
};

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = BlogComment::with(['blog:id,title','parent:id,name'])->latest();

            // ------------ Search ------------ //
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('comment', 'like', "%{$search}%");
                });
            }

            // ------------ Filters ------------ //
            if ($request->filled('blog_id')) {
                $query->where('blog_id', $request->blog_id);
            }

            if ($request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->filled('date_from')) {
                $query->whereDate(
                    'created_at',
                    '>=',
                    Carbon::parse($request->date_from)
                );
            }

            if ($request->filled('date_to')) {
                $query->whereDate(
                    'created_at',
                    '<=',
                    Carbon::parse($request->date_to)
                );
            }

            return DataTables::of($query)
                ->addIndexColumn()
                // ------------ Checkbox ------------ //
                ->addColumn('checkbox', function ($row) {
                    return view('admin.blog_comments.partials.checkbox', ['row' => $row])->render();
                })
                ->addColumn('blog', function ($row) {
                    return e(optional($row->blog)->title);
                })
                ->addColumn('user', function ($row) {
                    return '
                        <div>
                            <strong>'.$row->name.'</strong><br>
                            <small class="text-muted">'.$row->email.'</small>
                        </div>
                    ';
                })
                ->addColumn('comment', function ($row) {
                    return Str::limit(strip_tags($row->comment), 80);
                })
                ->addColumn('type', function ($row) {
                    if ($row->parent_id) {
                        return '<span class="badge bg-label-info">
                                    Reply
                                </span>';
                    }
                    return '<span class="badge bg-label-primary">
                                Comment
                            </span>';
                })
                ->addColumn('status', function ($row) {
                    return view('admin.blog_comments.partials.status', ['row' => $row])->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y h:i A');
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if (auth()->user()->can('blog-comments-view')) {
                        $buttons .= '
                            <a href="'.route('blog-comments.show',$row->id).'"
                                class="btn btn-sm btn-icon btn-text-primary">
                                <i class="ti ti-eye"></i>
                            </a>';
                    }
                    if (auth()->user()->can('blog-comments-delete')) {
                        $buttons .= '
                            <button
                                class="btn btn-sm btn-icon btn-text-danger deleteRecord"
                                data-url="'.route('blog-comments.destroy',$row->id).'">
                                <i class="ti ti-trash"></i>
                            </button>';
                    }
                    return $buttons;
                })
                ->rawColumns([
                    'checkbox',
                    'user',
                    'status',
                    'type',
                    'action'
                ])
                ->make(true);
        }
        $blogs = Blog::where('status',1)->orderBy('title')->get();
        return view('admin.blog_comments.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogComment $blogComment)
    {
        $blogComment->load(['blog','parent','children']);
        return view('admin.blog_comments.show', compact('blogComment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogComment $blogComment)
    {
        DB::beginTransaction();
        try {
            $blogComment->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Comment deleted successfully.'
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
            'ids.*' => 'exists:blog_comments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            BlogComment::whereIn('id', $request->ids)->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Selected comments deleted successfully.'
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
            'id' => 'required|exists:blog_comments,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = BlogComment::findOrFail($request->id);
        $comment->status = $request->boolean('status');
        $comment->approved_at = $request->boolean('status') ? now() : null;
        $comment->save();

        return response()->json([
            'status' => true,
            'message' => 'Comment status updated successfully.'
        ]);
    }
}
