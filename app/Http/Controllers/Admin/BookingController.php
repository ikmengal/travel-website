<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use App\Models\{
    Booking,
    Tour,
    User
};

class BookingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:bookings-list', only: ['index']),
            new Middleware('permission:bookings-create', only: ['create','store']),
            new Middleware('permission:bookings-edit', only: ['edit','update']),
            new Middleware('permission:bookings-view', only: ['show']),
            new Middleware('permission:bookings-delete', only: ['destroy','bulkDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Bookings Management';

        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('booking_status', 'pending')->count();
        $confirmedBookings = Booking::where('booking_status', 'confirmed')->count();
        $completedBookings = Booking::where('booking_status', 'completed')->count();
        $cancelledBookings = Booking::where('booking_status', 'cancelled')->count();
        $pendingPayments = Booking::where('payment_status', 'pending')->count();
        $paid = Booking::where('payment_status', 'paid')->count();
        $todayBookings = Booking::where('created_at', now())->count();
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('grand_total');
        $customers = User::whereHas('roles', function ($query) {
                        $query->where('name', 'Customer');
                    })->get();

        // --------------------- Filters --------------------- //
        $users = User::orderBy('name')->get();
        $tours = Tour::orderBy('title')->get();

        // ---------------------DataTable Ajax --------------------- //
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = Booking::with(['user','tour','departure']);

            // --------------------- Filters --------------------- //
            if ($request->filled('customer_filter')) {
                $query->where('user_id', $request->customer_filter);
            }

            if ($request->filled('tour_filter')) {
                $query->where('tour_id', $request->tour_filter);
            }

            if ($request->filled('booking_status')) {
                $query->where('booking_status', $request->booking_status);
            }

            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('booking_no', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($user) use ($search) {
                            $user->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('tour', function ($tour) use ($search) {
                            $tour->where('title', 'like', "%{$search}%");
                        });
                });
            }

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return view('admin.bookings.partials.checkbox',compact('row'));
            })
            ->addColumn('customer', function ($row) {
                return $row->user?->name ?? '-';
            })
            ->addColumn('tour', function ($row) {
                return $row->tour?->title ?? '-';
            })
            ->addColumn('departure', function ($row) {
                return optional($row->departure)->departure_date ?? '-';
            })
            ->editColumn('booking_status', function ($row) {
                return $this->bookingStatusBadge($row->booking_status);
            })
            ->editColumn('payment_status', function ($row) {
                return $this->paymentStatusBadge($row->payment_status);
            })
            ->editColumn('grand_total', function ($row) {
                return number_format($row->grand_total, 2) . ' ' . $row->currency;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.bookings.partials.action', compact('row'))->render();

            })
            ->rawColumns(['checkbox', 'booking_status', 'payment_status', 'action'])
            ->make(true);
        }
        return view('admin.bookings.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Booking";

        $users = User::orderBy('name')->get();
        $tours = Tour::where('status', true)->orderBy('title')->get();

        return view('admin.bookings.create',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'             => 'required|exists:users,id',
            'tour_id'             => 'required|exists:tours,id',
            'tour_departure_id'   => 'nullable|exists:tour_departures,id',

            'adults'              => 'required|integer|min:1',
            'children'            => 'nullable|integer|min:0',
            'infants'             => 'nullable|integer|min:0',

            'tour_price'          => 'required|numeric',
            'subtotal'            => 'required|numeric',
            'discount'            => 'nullable|numeric',
            'tax'                 => 'nullable|numeric',
            'grand_total'         => 'required|numeric',

            'currency'            => 'required|max:3',

            'booking_status'      => 'required|in:pending,confirmed,cancelled,completed,refunded',
            'payment_status'      => 'required|in:pending,paid,failed,refunded',

            'special_request'     => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            Booking::create([
                'booking_no' => 'BK-' . strtoupper(uniqid()),

                'user_id' => $request->user_id,
                'tour_id' => $request->tour_id,
                'tour_departure_id' => $request->tour_departure_id,

                'adults' => $request->adults,
                'children' => $request->children,
                'infants' => $request->infants,

                'tour_price' => $request->tour_price,
                'subtotal' => $request->subtotal,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'grand_total' => $request->grand_total,

                'currency' => $request->currency,

                'booking_status' => $request->booking_status,
                'payment_status' => $request->payment_status,

                'special_request' => $request->special_request,

                'confirmed_at' => $request->booking_status == 'confirmed'
                    ? now()
                    : null,

                'completed_at' => $request->booking_status == 'completed'
                    ? now()
                    : null,

                'cancelled_at' => $request->booking_status == 'cancelled'
                    ? now()
                    : null,
            ]);

            DB::commit();
            return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $title = "Booking Details";
        $booking->load(['user','tour','departure','payments','travelers','notes','reviews']);
        return view('admin.bookings.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $title = "Edit Booking";

        $users = User::orderBy('name')->get();
        $tours = Tour::with('departures')->where('status', true)->orderBy('title')->get();
        $booking->load(['departure','user','tour']);

        return view('admin.bookings.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'user_id'             => 'required|exists:users,id',
            'tour_id'             => 'required|exists:tours,id',
            'tour_departure_id'   => 'nullable|exists:tour_departures,id',

            'adults'              => 'required|integer|min:1',
            'children'            => 'nullable|integer|min:0',
            'infants'             => 'nullable|integer|min:0',

            'tour_price'          => 'required|numeric',
            'subtotal'            => 'required|numeric',
            'discount'            => 'nullable|numeric',
            'tax'                 => 'nullable|numeric',
            'grand_total'         => 'required|numeric',

            'currency'            => 'required|max:3',

            'booking_status'      => 'required|in:pending,confirmed,cancelled,completed,refunded',
            'payment_status'      => 'required|in:pending,paid,failed,refunded',

            'special_request'     => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $booking->update([
                'user_id' => $request->user_id,
                'tour_id' => $request->tour_id,
                'tour_departure_id' => $request->tour_departure_id,

                'adults' => $request->adults,
                'children' => $request->children,
                'infants' => $request->infants,

                'tour_price' => $request->tour_price,
                'subtotal' => $request->subtotal,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'grand_total' => $request->grand_total,

                'currency' => $request->currency,

                'booking_status' => $request->booking_status,
                'payment_status' => $request->payment_status,

                'special_request' => $request->special_request,

                'confirmed_at' => $request->booking_status == 'confirmed'
                    ? ($booking->confirmed_at ?? now())
                    : null,

                'completed_at' => $request->booking_status == 'completed'
                    ? ($booking->completed_at ?? now())
                    : null,

                'cancelled_at' => $request->booking_status == 'cancelled'
                    ? ($booking->cancelled_at ?? now())
                    : null,
            ]);

            DB::commit();
            return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Booking $booking)
    {
        $booking->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking deleted successfully.'
            ]);
        }

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array'
        ]);

        Booking::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected bookings deleted successfully.'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bookings,id',
            'status' => 'required|in:pending,confirmed,completed,cancelled,refunded',
        ]);

        $booking = Booking::findOrFail($request->id);

        $booking->booking_status = $request->status;

        $booking->confirmed_at = $request->status == 'confirmed'
            ? ($booking->confirmed_at ?? now())
            : null;

        $booking->completed_at = $request->status == 'completed'
            ? ($booking->completed_at ?? now())
            : null;

        $booking->cancelled_at = $request->status == 'cancelled'
            ? ($booking->cancelled_at ?? now())
            : null;

        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully.'
        ]);
    }

    public function changePaymentStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bookings,id',
            'status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $booking = Booking::findOrFail($request->id);

        $booking->payment_status = $request->status;

        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully.'
        ]);
    }

    /**
     * Get Tour Departures (AJAX).
     */
    public function getDepartures(Request $request)
    {
        $tour = Tour::with(['departures' => function ($query) {
            $query->where('status', true)
                ->orderBy('departure_date');
        }])->findOrFail($request->tour_id);

        return response()->json($tour->departures);
    }

    public function getCustomers(Request $request)
    {
        $customers = User::select('id', 'name', 'email')
            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');

                });

            })
            ->orderBy('name')
            ->limit(20)
            ->get();

        return response()->json($customers);
    }

    public function getTours(Request $request)
    {
        $tours = Tour::select(
                'id',
                'title',
                'price'
            )
            ->where('status', true)
            ->when($request->search, function ($query) use ($request) {

                $query->where('title', 'like', '%' . $request->search . '%');

            })
            ->orderBy('title')
            ->limit(20)
            ->get();

        return response()->json($tours);
    }

    function bookingStatusBadge($status)
    {
        return match ($status) {

            'pending' => '<span class="badge bg-label-warning">Pending</span>',

            'confirmed' => '<span class="badge bg-label-success">Confirmed</span>',

            'completed' => '<span class="badge bg-label-primary">Completed</span>',

            'cancelled' => '<span class="badge bg-label-danger">Cancelled</span>',

            'refunded' => '<span class="badge bg-label-dark">Refunded</span>',

            default => '<span class="badge bg-label-secondary">Unknown</span>',
        };
    }

    function paymentStatusBadge($status)
    {
        return match ($status) {

            'pending' => '<span class="badge bg-label-warning">Pending</span>',

            'paid' => '<span class="badge bg-label-success">Paid</span>',

            'failed' => '<span class="badge bg-label-danger">Failed</span>',

            'refunded' => '<span class="badge bg-label-info">Refunded</span>',

            default => '<span class="badge bg-label-secondary">Unknown</span>',
        };
    }
}
