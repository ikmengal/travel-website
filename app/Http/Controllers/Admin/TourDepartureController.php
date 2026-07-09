<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB, Log
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    TourDeparture,
    Tour
};

class TourDepartureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {

            $query = TourDeparture::with('tour');

            // Tour Filter
            if ($request->filled('tour')) {
                $query->where('tour_id', $request->tour);
            }

            // Status Filter
            if ($request->status != '') {
                $query->where('status', $request->status);
            }

            // Departure Date Filter
            if ($request->filled('departure_date')) {
                $query->whereDate('departure_date', $request->departure_date);
            }

            // Search
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('price', 'like', '%' . $request->search . '%')
                        ->orWhere('available_seats', 'like', '%' . $request->search . '%')
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
            ->editColumn('departure_date', function ($row) {
                return '<span class="badge bg-label-primary">'
                    . $row->departure_date->format('d M Y')
                    . '</span>';
            })
            ->editColumn('return_date', function ($row) {
                return '<span class="badge bg-label-warning">'
                    . $row->return_date->format('d M Y')
                    . '</span>';
            })
            ->editColumn('price', function ($row) {
                return 'Rs. ' . number_format($row->price, 2);
            })
            ->editColumn('available_seats', function ($row) {
                return '<span class="badge bg-label-info">'
                    . $row->available_seats .
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
                return view('admin.tour-departures.action',compact('row'))->render();
            })
            ->rawColumns(['checkbox', 'departure_date', 'return_date', 'available_seats', 'status', 'action'])
            ->make(true);
        }

        $title = 'Tour Departures';
        $tours = Tour::where('status', 1)->orderBy('title')->get();
        $totalDepartures = TourDeparture::count();
        $upcomingDepartures = TourDeparture::whereDate('departure_date', '>=', now())->count();
        $completedDepartures = TourDeparture::whereDate('departure_date', '<', now())->count();
        $activeDepartures = TourDeparture::where('status', 1)->count();

        return view('admin.tour-departures.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Tour Departure';
        $tours = Tour::where('status', 1)->orderBy('title')->get();
        return view('admin.tour-departures.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|exists:tours,id',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
            'available_seats' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            TourDeparture::create([
                'tour_id' => $request->tour_id,
                'departure_date' => $request->departure_date,
                'return_date' => $request->return_date,
                'available_seats' => $request->available_seats,
                'price' => $request->price,
                'status' => $request->status ? 1 : 0,
            ]);

            return redirect()->route('tour_departures.index')->with('success', 'Tour Departure Created Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TourDeparture $tourDeparture)
    {
        $title = 'Tour Departure Details';
        $tourDeparture->load('tour');
        $tourDeparture = $tourDeparture;
        return view('admin.tour-departures.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourDeparture $tourDeparture)
    {
        $title = 'Edit Tour Departure';

        $tourDeparture->load('tour');
        $tourDeparture = $tourDeparture;
        $tours = Tour::where('status', 1)->orderBy('title')->get();

        return view('admin.tour-departures.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourDeparture $tourDeparture)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|exists:tours,id',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
            'available_seats' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $tourDeparture->update([
                'tour_id' => $request->tour_id,
                'departure_date' => $request->departure_date,
                'return_date' => $request->return_date,
                'available_seats' => $request->available_seats,
                'price' => $request->price,
                'status' => $request->status ? 1 : 0,
            ]);

            return redirect()->route('tour_departures.index')->with('success', 'Tour Departure Updated Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourDeparture $tourDeparture)
    {
        try {
            $tourDeparture->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tour Departure Deleted Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:tour_departures,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $tourDeparture = TourDeparture::findOrFail($request->id);
            $tourDeparture->status = !$tourDeparture->status;
            $tourDeparture->save();

            return response()->json([
                'success' => true,
                'message' => 'Status Updated Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ids' => 'required|array',
                'ids.*' => 'exists:tour_departures,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            TourDeparture::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected Tour Departures Deleted Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
