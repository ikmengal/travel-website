<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB,
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Counter;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $counters = Counter::query();
            return DataTables::of($counters)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->filled('search')) {
                        $query->where('title', 'like', '%' . $request->search . '%');
                    }
                    if ($request->filled('status')) {
                        $query->where('status', $request->status);
                    }
                })
                ->addColumn('checkbox', function ($row) {
                    return view('admin.counters.partials.checkbox', compact('row'))->render();
                })
                ->addColumn('icon', function ($row) {
                    return '<i class="'.$row->icon.' fs-3"></i>';
                })
                ->addColumn('value', function ($row) {
                    return $row->prefix . number_format($row->number) . $row->suffix;
                })
                ->editColumn('status', function ($row) {
                    return view('admin.counters.partials.switch-status', compact('row'))->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin.counters.action', compact('row'))->render();
                })
                ->rawColumns([
                    'checkbox',
                    'icon',
                    'status',
                    'action'
                ])
                ->make(true);
            }
        return view('admin.counters.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.counters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'icon' => 'required|string|max:100',
            'title' => 'required|string|max:255|unique:counters,title',
            'number' => 'required|numeric|min:0',
            'prefix' => 'nullable|string|max:20',
            'suffix' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            Counter::create([
                'icon' => $request->icon,
                'title' => $request->title,
                'number' => $request->number,
                'prefix' => $request->prefix,
                'suffix' => $request->suffix,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Counter created successfully.'
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
    public function show(Counter $counter)
    {
        return view('admin.counters.show', compact('counter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Counter $counter)
    {
        return view('admin.counters.edit', compact('counter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Counter $counter)
    {
        $validator = Validator::make($request->all(), [
            'icon' => 'required|string|max:100',
            'title' => 'required|string|max:255|unique:counters,title,' . $counter->id,
            'number' => 'required|numeric|min:0',
            'prefix' => 'nullable|string|max:20',
            'suffix' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $counter->update([
                'icon' => $request->icon,
                'title' => $request->title,
                'number' => $request->number,
                'prefix' => $request->prefix,
                'suffix' => $request->suffix,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Counter updated successfully.'
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
    public function destroy(Counter $counter)
    {
        try {

            $counter->delete();

            return response()->json([
                'status' => true,
                'message' => 'Counter deleted successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function changeStatus(Request $request)
    {
        $counter = Counter::findOrFail($request->id);

        $counter->status = $request->status;
        $counter->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        Counter::whereIn('id', $request->ids)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Selected counters deleted successfully.'
        ]);
    }
}
