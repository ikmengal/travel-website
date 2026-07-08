<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    validator, File, Log, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    TourCategory
};
use Dotenv\Validator as DotenvValidator;

class TourCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('tour-category-list');

        $title = "Tour Categories";

        if ($request->ajax() && $request->loaddata == "yes") {
            $query = TourCategory::with(['tours']);
            return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($query) {
                return view('admin.tour_categories.partials.checkbox',compact('query'))->render();
            })
            ->addColumn('icon', function ($query) {
                return view('admin.tour_categories.partials.profile',compact('query'))->render();
            })
            ->addColumn('status', function ($query) {
                $label = '-';
                switch ($query->status) {
                    case 1:
                        $label = '<span class="badge bg-label-success">Active</span>';
                        break;
                    case 0:
                        $label = '<span class="badge bg-label-danger">In Active</span>';
                        break;
                }
                return $label;
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('d M Y');
            })
            ->addColumn('action', function ($query) {
                return view('admin.tour_categories.partials.action',compact('query'))->render();
            })
            ->rawColumns(['checkbox', 'icon', 'status', 'action'])
            ->make(true);
        }
        return view('admin.tour_categories.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('tour-category-create');
        return (string) view('admin.tour_categories.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('destinations-create');

        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255|unique:tour_categories,name',
            'icon'       => 'nullable|max:100',
            'color'      => 'nullable|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'status'     => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            TourCategory::create([
                'name'       => $request->name,
                'slug'       => Str::slug($request->name),
                'icon'       => $request->icon,
                'color'      => $request->color,
                'sort_order' => $request->sort_order ?? 0,
                'status'     => $request->boolean('status'),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tour Category created successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TourCategory $tour_category)
    {
        $this->authorize('tour-category-list');

        return (string) view(
            'admin.tour_categories.show',
            compact('tour_category')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourCategory $tour_category)
    {
        $this->authorize('tour-category-edit');
        return (string) view('admin.tour_categories.edit',compact('tour_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourCategory $tour_category)
    {
        $this->authorize('tour-category-edit');

        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255|unique:tour_categories,name,' . $tour_category->id,
            'icon'       => 'nullable|max:255',
            'color'      => 'nullable|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'status'     => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ],422);
        }

        try {

            $tour_category->update([
                'name'       => $request->name,
                'slug'       => Str::slug($request->name),
                'icon'       => $request->icon,
                'color'      => $request->color,
                'sort_order' => $request->sort_order ?? 0,
                'status'     => $request->status,
            ]);

            return response()->json([
                'success'=>true,
                'message'=>'Tour Category updated successfully.'
            ]);

        } catch (\Exception $e) {

            Log::error($e);

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourCategory $tour_category)
    {
        $this->authorize('tour-category-delete');

        try {

            if ($tour_category->tours()->count() > 0) {

                return response()->json([
                    'success'=>false,
                    'message'=>'Category cannot be deleted because tours exist.'
                ],422);

            }

            $tour_category->delete();

            return response()->json([
                'success'=>true,
                'message'=>'Tour Category deleted successfully.'
            ]);

        } catch (\Exception $e) {

            Log::error($e);

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);

        }
    }
}
