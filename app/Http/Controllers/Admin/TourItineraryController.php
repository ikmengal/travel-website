<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, File, DB, Log
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    TourItinerary,
    TourImage, Tour
};

class TourItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = TourItinerary::with('tour');

            if ($request->tour != "") {
                $query->where('tour_id', $request->tour);
            }

            if ($request->status != "") {
                $query->where('status', $request->status);
            }

            if ($request->search != "") {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%')
                        ->orWhere('day', 'like', '%' . $request->search . '%');
                });
            }

            return DataTables::of($query)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" value="'.$row->id.'" class="form-check-input row-checkbox">';
            })
            ->addColumn('tour', function ($row) {
                return $row->tour?->title ?? '-';
            })
            ->editColumn('day', function ($row) {
                return '<span class="badge bg-label-primary">Day '.$row->day.'</span>';
            })
            ->editColumn('description', function ($row) {
                return Str::words(strip_tags($row->description),20,'...');
            })
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '
                <div class="form-check form-switch">
                    <input
                        type="checkbox"
                        class="form-check-input changeStatus"
                        data-id="'.$row->id.'"
                        '.$checked.'>
                </div>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.tour_itineraries.action', compact('row'))->render();
            })
            ->rawColumns(['checkbox', 'day', 'status', 'action'])
            ->make(true);
        }

        $data['title'] = "Tour Itineraries";
        $data['tours'] = Tour::orderBy('title')->get();
        $data['totalItineraries'] = TourItinerary::count();
        $data['activeItineraries'] = TourItinerary::where('status',1)->count();
        $data['inactiveItineraries'] = TourItinerary::where('status',0)->count();
        $data['totalTours'] = Tour::count();
        return view('admin.tour_itineraries.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add Tour Itinerary";
        $tours = Tour::where('status',1)->orderBy('title')->get();
        return view('admin.tour_itineraries.create',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|exists:tours,id',
            'day' => 'required|integer|min:1',
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            TourItinerary::create([
                'tour_id' => $request->tour_id,
                'day' => $request->day,
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status ? 1 : 0,
            ]);

            return redirect()->route('tour_itineraries.index')->with('success','Tour Itinerary Created Successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TourItinerary $tourItinerary)
    {
        $title = "Tour Itinerary Details";
        $itinerary = $tourItinerary->load('tour');
        return view('admin.tour_itineraries.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourItinerary $tourItinerary)
    {
        $title = "Edit Tour Itinerary";

        $itinerary = $tourItinerary;
        $tours = Tour::where('status',1)->orderBy('title')->get();

        return view('admin.tour_itineraries.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourItinerary $tourItinerary)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|exists:tours,id',
            'day' => 'required|integer|min:1',
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $tourItinerary->update([
                'tour_id' => $request->tour_id,
                'day' => $request->day,
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status ? 1 : 0,
            ]);

            return redirect()->route('tour_itineraries.index')->with('success','Tour Itinerary Updated Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourItinerary $tourItinerary)
    {
        try {
            $tourItinerary->delete();
            return response()->json([
                'success' => true,
                'message' => 'Tour Itinerary Deleted Successfully.'
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
            $itinerary = TourItinerary::findOrFail($request->id);

            $itinerary->status = !$itinerary->status;
            $itinerary->save();

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
            TourItinerary::whereIn('id',$request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected Itineraries Deleted Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
