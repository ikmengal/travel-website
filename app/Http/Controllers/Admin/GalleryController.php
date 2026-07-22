<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Gallery;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $galleries = Gallery::query();
            return DataTables::of($galleries)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('search')) {
                        $query->where(function ($q) use ($request) {
                            $q->where('title', 'like', "%{$request->search}%")
                            ->orWhere('category', 'like', "%{$request->search}%")
                            ->orWhere('caption', 'like', "%{$request->search}%");
                        });
                    }

                    if ($request->filled('category')) {
                        $query->where('category', $request->category);
                    }

                    if ($request->status !== null && $request->status !== '') {
                        $query->where('status', $request->status);
                    }

                    if ($request->featured !== null && $request->featured !== '') {
                        $query->where('featured', $request->featured);
                    }
                })
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="form-check-input row-checkbox" value="'.$row->id.'">';
                })
                ->addColumn('image', function ($row) {
                    return '<img src="'.$row->image.'" width="80" height="55"
                            class="rounded border object-fit-cover">';
                })
                ->editColumn('category', function ($row) {
                    return $row->category
                        ? '<span class="badge bg-label-info">'.$row->category.'</span>'
                        : '-';
                })
                ->editColumn('featured', function ($row) {
                    return view('admin.components.switch-featured', [
                        'id'=>$row->id,
                        'checked'=>$row->featured,
                        'class'=>'featured-switch'
                    ])->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.components.switch-status', [
                        'id'=>$row->id,
                        'checked'=>$row->status,
                        'class'=>'status-switch'
                    ])->render();
                })
                ->editColumn('sort_order', function ($row) {
                    return '<span class="badge bg-label-dark">'.$row->sort_order.'</span>';
                })
                ->addColumn('action', function ($row) {
                    return view('admin.gallery.action', compact('row'))->render();
                })
                ->rawColumns([
                    'checkbox',
                    'image',
                    'category',
                    'featured',
                    'status',
                    'sort_order',
                    'action'
                ])
                ->make(true);
        }
        $categories = Gallery::query()
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
        return view('admin.gallery.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:galleries,slug',
            'category' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'caption' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'featured' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $gallery = new Gallery();
            $gallery->title = $request->title;
            $gallery->slug = Str::slug($request->slug);
            $gallery->category = $request->category;
            $gallery->caption = $request->caption;
            $gallery->description = $request->description;
            $gallery->sort_order = $request->sort_order ?? 0;
            $gallery->featured = $request->featured;
            $gallery->status = $request->status;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/gallery'), $imageName);
                $gallery->image = $imageName;
            }

            $gallery->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Gallery image created successfully.'
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
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:galleries,slug,' . $gallery->id,
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'caption' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'featured' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $gallery->title = $request->title;
            $gallery->slug = Str::slug($request->slug);
            $gallery->category = $request->category;
            $gallery->caption = $request->caption;
            $gallery->description = $request->description;
            $gallery->sort_order = $request->sort_order ?? 0;
            $gallery->featured = $request->featured;
            $gallery->status = $request->status;
            if ($request->hasFile('image')) {
                $oldImage = $gallery->getRawOriginal('image');
                if ($oldImage && file_exists(public_path('images/gallery/' . $oldImage))) {
                    unlink(public_path('images/gallery/' . $oldImage));
                }
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/gallery'), $imageName);
                $gallery->image = $imageName;
            }

            $gallery->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Gallery updated successfully.'
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
    public function destroy(Gallery $gallery)
    {
        try {

            $image = $gallery->getRawOriginal('image');

            if ($image && file_exists(public_path('images/gallery/' . $image))) {
                unlink(public_path('images/gallery/' . $image));
            }

            $gallery->image = null;
            $gallery->save();

            $gallery->delete();

            return response()->json([
                'status' => true,
                'message' => 'Gallery image deleted successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function changeFeatured(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);

        $gallery->featured = $request->featured;

        $gallery->save();

        return response()->json([
            'status' => true,
            'message' => 'Featured status updated successfully.'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);

        $gallery->status = $request->status;

        $gallery->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $galleries = Gallery::whereIn('id', $request->ids)->get();

        foreach ($galleries as $gallery) {

            $image = $gallery->getRawOriginal('image');

            if ($image && file_exists(public_path('images/gallery/' . $image))) {
                unlink(public_path('images/gallery/' . $image));
            }

            $gallery->image = null;
            $gallery->save();

            $gallery->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Selected gallery images deleted successfully.'
        ]);
    }
}
