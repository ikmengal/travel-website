<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    TourInclude,
    Tour
};

class TourIncludeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = TourInclude::with('tour');

            if ($request->filled('tour')) {
                $query->where('tour_id', $request->tour);
            }

            if ($request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('icon', 'like', '%' . $request->search . '%')
                    ->orWhereHas('tour', function ($tour) use ($request) {
                        $tour->where('title', 'like', '%' . $request->search . '%');
                    });
                });
            }

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="form-check-input row-checkbox" value="' . $row->id . '">';
            })
            ->addColumn('tour', function ($row) {
                return $row->tour->title ?? '-';
            })
            ->addColumn('icon', function ($row) {
                return '
                    <div class="d-flex align-items-center">
                        <i class="' . $row->icon . ' fs-4 me-2"></i>
                        <span>' . $row->icon . '</span>
                    </div>';
            })
            ->editColumn('title', function ($row) {
                return '<strong>' . $row->title . '</strong>';
            })
            ->editColumn('sort_order', function ($row) {
                return '<span class="badge bg-label-info">'
                    . $row->sort_order .
                    '</span>';
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
                    </div>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.tour_includes.action',compact('row'))->render();
            })
            ->rawColumns(['checkbox', 'icon', 'title', 'sort_order', 'status', 'action'])
            ->make(true);
        }

        $title = 'Tour Includes';
        $tours = Tour::orderBy('title')->get();
        $totalIncludes = TourInclude::count();
        $activeIncludes = TourInclude::where('status',1)->count();
        $inactiveIncludes = TourInclude::where('status',0)->count();
        $totalTours = Tour::count();
        return view('admin.tour_includes.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Tour Include';
        $tours = Tour::where('status',1)->orderBy('title')->get();
        return view('admin.tour_includes.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'tour_id'    => 'required|exists:tours,id',
            'title'      => 'required|max:255',
            'icon'       => 'nullable|max:100',
            'sort_order' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            TourInclude::create([
                'tour_id'    => $request->tour_id,
                'title'      => $request->title,
                'icon'       => $request->icon,
                'sort_order' => $request->sort_order ?? 0,
                'status'     => $request->status ? 1 : 0,
            ]);

            return redirect()->route('tour_includes.index')->with('success','Tour Include Created Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TourInclude $tourInclude)
    {
        $tourInclude->load('tour');

        $title = 'Tour Include Details';
        $tourInclude = $tourInclude;

        return view('admin.tour_includes.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourInclude $tourInclude)
    {
        $title = 'Edit Tour Include';

        $tourInclude->load('tour');
        $tourInclude = $tourInclude;
        $tours = Tour::where('status',1)->orderBy('title')->get();

        return view('admin.tour_includes.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourInclude $tourInclude)
    {
        $validator = Validator::make($request->all(), [
            'tour_id'    => 'required|exists:tours,id',
            'title'      => 'required|max:255',
            'icon'       => 'nullable|max:100',
            'sort_order' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $tourInclude->update([
                'tour_id'    => $request->tour_id,
                'title'      => $request->title,
                'icon'       => $request->icon,
                'sort_order' => $request->sort_order ?? 0,
                'status'     => $request->status ? 1 : 0,
            ]);

            return redirect()->route('tour_includes.index')->with('success','Tour Include Updated Successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourInclude $tourInclude)
    {
        try {
            $tourInclude->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tour Include Deleted Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $include = TourInclude::findOrFail($request->id);

            $include->status = !$include->status;
            $include->save();

            return response()->json([
                'success' => true,
                'message' => 'Status Updated Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            TourInclude::whereIn('id',$request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected Tour Includes Deleted Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
