<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\{
    HasMiddleware, Middleware
};
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    Booking,
    Payment
};

class PaymentsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:payments-list', only: ['index']),
            new Middleware('permission:payments-create', only: ['create', 'store']),
            new Middleware('permission:payments-edit', only: ['edit', 'update']),
            new Middleware('permission:payments-show', only: ['show']),
            new Middleware('permission:payments-delete', only: ['destroy', 'bulkDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = Payment::with(['booking.user','booking.tour']);

            // ---------------- Filters ---------------- //
            if ($request->filled('booking_id')) {
                $query->where('booking_id', $request->booking_id);
            }

            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }

            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            if ($request->filled('payment_date')) {
                $query->whereDate('payment_date', $request->payment_date);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('payment_no', 'like', "%{$search}%")
                        ->orWhere('transaction_id', 'like', "%{$search}%")
                        ->orWhereHas('booking.user', function ($qq) use ($search) {
                            $qq->where('name', 'like', "%{$search}%");
                        });
                });
            }

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return view('admin.payments.partials.checkbox', compact('row'));
            })
            ->addColumn('booking', function ($row) {
                return $row->booking->booking_no ?? '-';
            })
            ->addColumn('customer', function ($row) {
                return $row->booking->user->name ?? '-';
            })
            ->editColumn('payment_method', function ($row) {
                return paymentMethodBadge($row->payment_method);
            })
            ->editColumn('amount', function ($row) {
                return number_format($row->amount, 2);
            })
            ->editColumn('payment_status', function ($row) {
                return paymentStatusBadge($row->payment_status);
            })
            ->editColumn('paid_at', function ($row) {
                return $row->paid_at ?? '-';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.payments.partials.action', compact('row'));
            })
            ->rawColumns(['checkbox', 'payment_method', 'payment_status', 'action',])
            ->make(true);
        }
        // ---------------- Dashboard Cards ---------------- //
        $cards = [
            'total'      => Payment::count(),
            'today'      => Payment::whereDate('created_at', today())->count(),
            'pending'    => Payment::where('status', 'pending')->count(),
            'paid'       => Payment::where('status', 'paid')->count(),
            'refunded'   => Payment::where('status', 'refunded')->count(),
            'revenue'    => Payment::where('status', 'paid')->sum('amount'),
        ];

        $bookings = Booking::with('user')->latest()->get();
        $title = 'Payments';
        return view('admin.payments.index', get_defined_vars()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Payment';
        $bookings = Booking::with(['user','tour'])->latest()->get();
        return view('admin.payments.create', compact('title','bookings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id'        => 'required|exists:bookings,id',
            'payment_no'        => 'required|string|max:100|unique:payments,payment_no',
            'transaction_id'    => 'nullable|string|max:255',
            'payment_method'    => 'required|string|max:100',
            'payment_gateway'   => 'nullable|string|max:255',
            'amount'            => 'required',
            'currency'          => 'required|string|max:3',
            'payment_status'    => 'required|in:pending,paid,failed,refunded,cancelled',
            'payment_date'      => 'required|date',
            'reference_no'      => 'nullable|string|max:255',
            'notes'             => 'nullable|string',
            'receipt'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status'            => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $receipt = null;
            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/payments'), $filename);
                $receipt = 'images/payments/' . $filename;
            }

            Payment::create([
                'booking_id'       => $request->booking_id,
                'payment_no'       => $request->payment_no,
                'transaction_id'   => $request->transaction_id,
                'payment_method'   => $request->payment_method,
                'gateway'          => $request->payment_gateway,
                'amount'           => $request->amount,
                'currency'         => strtoupper($request->currency),
                'reference_no'     => $request->reference_no,
                'receipt'          => $receipt,
                'notes'            => $request->notes,
                'status'           => $request->status ?? 0,
                'payment_status'   => $request->payment_status,
                'paid_at'          => $request->payment_date,
            ]);

            DB::commit();
            return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($receipt && file_exists(public_path($receipt))) {
                @unlink(public_path($receipt));
            }
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $title = 'Payment Details';
        $payment->load(['booking.user','booking.tour',]);
        return view('admin.payments.show',compact('title','payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $title = 'Edit Payment';
        $payment->load(['booking.user','booking.tour',]);
        $bookings = Booking::with(['user','tour',])->latest()->get();

        return view('admin.payments.edit', compact('title','payment','bookings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validator = Validator::make($request->all(), [
            'booking_id'       => 'required|exists:bookings,id',
            'payment_no'       => 'required|string|max:100|unique:payments,payment_no,' . $payment->id,
            'transaction_id'   => 'nullable|string|max:255',
            'payment_method'   => 'required|string|max:100',
            'payment_gateway'  => 'nullable|string|max:255',
            'amount'           => 'required',
            'currency'         => 'required|string|max:3',
            'payment_status'   => 'required|in:pending,paid,failed,refunded,cancelled',
            'payment_date'     => 'required|date',
            'reference_no'     => 'nullable|string|max:255',
            'receipt'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes'            => 'nullable|string',
            'status'           => 'nullable|boolean',
        ]);

        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();

        }

        DB::beginTransaction();

        try {
            $receipt = $payment->receipt;
            if ($request->hasFile('receipt')) {
                if ($receipt && file_exists(public_path($receipt))) {
                    @unlink(public_path($receipt));
                }

                $file = $request->file('receipt');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/payments'), $filename);
                $receipt = 'images/payments/' . $filename;
            }

            $payment->update([
                'booking_id'      => $request->booking_id,
                'payment_no'      => $request->payment_no,
                'transaction_id'  => $request->transaction_id,
                'payment_method'  => $request->payment_method,
                'gateway'         => $request->payment_gateway,
                'amount'          => $request->amount,
                'currency'        => strtoupper($request->currency),
                'payment_status'  => $request->payment_status,
                'paid_at'    => $request->payment_date,
                'reference_no'    => $request->reference_no,
                'receipt'         => $receipt,
                'notes'           => $request->notes,
                'status'          => $request->status ?? 0,
            ]);

            DB::commit();
            return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Payment $payment)
    {
        DB::beginTransaction();

        try {

            if ($payment->receipt && file_exists(public_path($payment->receipt))) {

                @unlink(public_path($payment->receipt));

            }

            $payment->delete();

            DB::commit();

            if ($request->ajax()) {

                return response()->json([
                    'status'  => true,
                    'message' => 'Payment deleted successfully.'
                ]);
            }

            return redirect()
                ->route('payments.index')
                ->with('success', 'Payment deleted successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            if ($request->ajax()) {

                return response()->json([
                    'status'  => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Bulk Delete Payments
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'ids' => 'required|array',

            'ids.*' => 'exists:payments,id',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $payments = Payment::whereIn('id', $request->ids)->get();

            foreach ($payments as $payment) {

                if ($payment->receipt && file_exists(public_path($payment->receipt))) {

                    @unlink(public_path($payment->receipt));

                }

                $payment->delete();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Selected payments deleted successfully.'
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
     * Change Payment Status
     */
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id' => 'required|exists:payments,id',

            'payment_status' => 'required|in:pending,paid,failed,refunded,cancelled',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {

            $payment = Payment::findOrFail($request->id);

            $payment->update([
                'payment_status' => $request->payment_status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Payment status updated successfully.'
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
        $booking = Booking::with([
            'user',
            'tour'
        ])->find($request->booking_id);

        if (!$booking) {

            return response()->json([
                'status' => false,
                'message' => 'Booking not found.'
            ]);
        }

        return response()->json([

            'status' => true,

            'customer' => $booking->user->name ?? '-',

            'tour' => $booking->tour->title ?? '-',

            'grand_total' => number_format($booking->grand_total, 2),

            'currency' => $booking->currency,

        ]);
    }
}
