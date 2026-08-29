<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\{
    HasMiddleware, Middleware
};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use App\Models\{
    BookingTraveler,
    Booking
};

class BookingTravelerController extends Controller implements HasMiddleware
{
    /**
     * Constructor
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:booking-travelers-list', only: ['index']),
            new Middleware('permission:booking-travelers-create', only: ['create', 'store']),
            new Middleware('permission:booking-travelers-edit', only: ['edit', 'update']),
            new Middleware('permission:booking-travelers-show', only: ['show']),
            new Middleware('permission:booking-travelers-delete', only: ['destroy', 'bulkDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = BookingTraveler::with([
                'booking.user',
                'booking.tour'
            ]);

            // --------------- Filters --------------- //
            if ($request->filled('booking_id')) {
                $query->where('booking_id', $request->booking_id);
            }

            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            if ($request->filled('nationality')) {
                $query->where('nationality', 'like', '%' . $request->nationality . '%');
            }

            if ($request->status !== null && $request->status !== '') {
                $query->where('status', $request->status);
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return view('admin.booking_travelers.partials.checkbox',compact('row'));
                })
                ->addColumn('traveler', function ($row) {
                    return '<strong>' . ($row->first_name) . '</strong>';
                })
                ->addColumn('booking', function ($row) {
                    return $row->booking->booking_no ?? '-';
                })
                ->addColumn('customer', function ($row) {
                    return $row->booking->user->name ?? '-';
                })
                ->addColumn('tour', function ($row) {
                    return $row->booking->tour->title ?? '-';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge bg-label-success">Active</span>';
                    }
                    return '<span class="badge bg-label-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return view('admin.booking_travelers.partials.action',compact('row'));
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->rawColumns(['checkbox', 'traveler', 'status', 'action'])
                ->make(true);
        }

        // --------------- Dashboard Cards --------------- //
        $cards = [
            'total' => BookingTraveler::count(),
            'today' => BookingTraveler::whereDate('created_at', today())->count(),
            'male' => BookingTraveler::where('gender', 'male')->count(),
            'female' => BookingTraveler::where('gender', 'female')->count(),
            'active' => BookingTraveler::where('status', 1)->count(),
            'inactive' => BookingTraveler::where('status', 0)->count(),
        ];

        $bookings = Booking::orderBy('booking_no')->get();
        $title = 'Booking Travelers';
        return view('admin.booking_travelers.index', get_defined_vars()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Booking Traveler';
        $bookings = Booking::with(['user', 'tour'])->orderByDesc('id')->get();

        return view('admin.booking_travelers.create', get_defined_vars()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'cnic' => 'nullable|string|max:30',
            'passport_number' => 'nullable|string|max:100',
            'passport_expiry' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            BookingTraveler::create([
                'booking_id' => $request->booking_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'nationality' => $request->nationality,
                'cnic' => $request->cnic,
                'passport_number' => $request->passport_number,
                'passport_expiry' => $request->passport_expiry,
                'email' => $request->email,
                'phone' => $request->phone,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'address' => $request->address,
                'notes' => $request->notes,
                'status' => $request->status ?? 0,
            ]);

            DB::commit();

            return redirect()->route('booking_travelers.index')->with('success', 'Booking Traveler created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BookingTraveler $bookingTraveler)
    {
        $bookingTraveler->load([
            'booking.user',
            'booking.tour',
        ]);

        $title = 'Traveler Details';

        return view('admin.booking_travelers.show',
            [
                'title' => $title,
                'traveler' => $bookingTraveler,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookingTraveler $bookingTraveler)
    {
        $bookingTraveler->load([
            'booking.user',
            'booking.tour',
        ]);

        $title = 'Edit Booking Traveler';

        $bookings = Booking::with([
            'user',
            'tour',
        ])->orderByDesc('id')->get();

        return view('admin.booking_travelers.edit',[
                'title' => $title,
                'traveler' => $bookingTraveler,
                'bookings' => $bookings,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookingTraveler $bookingTraveler)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'cnic' => 'nullable|string|max:30',
            'passport_number' => 'nullable|string|max:100',
            'passport_expiry' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $bookingTraveler->update([
                'booking_id' => $request->booking_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'nationality' => $request->nationality,
                'cnic' => $request->cnic,
                'passport_number' => $request->passport_number,
                'passport_expiry' => $request->passport_expiry,
                'email' => $request->email,
                'phone' => $request->phone,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'address' => $request->address,
                'notes' => $request->notes,
                'status' => $request->status ?? 0,
            ]);

            DB::commit();

            return redirect()->route('booking_travelers.index')->with('success', 'Booking Traveler updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BookingTraveler $bookingTraveler)
    {
        try {
            $bookingTraveler->delete();
            if ($request->ajax()) {
                return response()->json([
                    'status'  => true,
                    'message' => 'Traveler deleted successfully.'
                ]);
            }

            return redirect()
                ->route('booking-travelers.index')
                ->with('success', 'Traveler deleted successfully.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the Bulk records resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'ids' => 'required|array|min:1',

            'ids.*' => 'exists:booking_travelers,id',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);

        }

        DB::beginTransaction();

        try {

            BookingTraveler::whereIn('id', $request->ids)->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Selected travelers deleted successfully.'
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

            'id' => 'required|exists:booking_travelers,id',

            'status' => 'required|boolean',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);

        }

        try {

            $traveler = BookingTraveler::findOrFail($request->id);

            $traveler->update([
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Traveler status updated successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    /**
     * Get Booking Details (AJAX)
     */
    public function getBookings(Request $request)
    {
        $booking = Booking::with(['user','tour'])->find($request->booking_id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found.'
            ], 404);

        }

        return response()->json([

            'status' => true,

            'customer' => $booking->user->name ?? '-',

            'tour' => $booking->tour->title ?? '-',

            'booking_no' => $booking->booking_no,

            'booking_id' => $booking->id,

        ]);
    }
}
