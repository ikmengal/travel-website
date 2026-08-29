<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\{
    HasMiddleware, Middleware
};
use Illuminate\Support\Facades\{
    DB, Validator
};
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:coupons-list', only: ['index']),
            new Middleware('permission:coupons-create', only: ['create', 'store']),
            new Middleware('permission:coupons-show', only: ['show']),
            new Middleware('permission:coupons-edit', only: ['edit', 'update']),
            new Middleware('permission:coupons-delete', only: ['destroy', 'bulkDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == 'yes') {
            $query = Coupon::query();
            // ---------------- Filters ---------------- //
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            if ($request->filled('starts_at')) {
                $query->whereDate('starts_at', $request->starts_at);
            }

            if ($request->filled('expires_at')) {
                $query->whereDate('expires_at', $request->expires_at);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return view('admin.coupons.partials.checkbox',compact('row'));
                })
                ->editColumn('type', function ($row) {
                    return couponTypeBadge($row->type);
                })
                ->editColumn('value', function ($row) {
                    if ($row->type == 'percentage') {
                        return $row->value . ' %';
                    }
                    return number_format($row->value, 2);
                })
                ->editColumn('minimum_amount', function ($row) {
                    return number_format($row->minimum_amount, 2);
                })
                ->editColumn('maximum_discount', function ($row) {
                    return $row->maximum_discount
                        ? number_format($row->maximum_discount, 2)
                        : '-';
                })
                ->editColumn('usage_limit', function ($row) {
                    return $row->usage_limit ?? 'Unlimited';
                })
                ->editColumn('used', function ($row) {
                    return $row->used;
                })
                ->editColumn('starts_at', function ($row) {
                    return $row->starts_at ?? '' ;
                })
                ->editColumn('expires_at', function ($row) {
                    return $row->expires_at ?? '-' ;
                })
                ->editColumn('status', function ($row) {
                    return statusBadge($row->status);
                })
                ->addColumn('action', function ($row) {
                    return view('admin.coupons.partials.action',compact('row'));
                })
                ->rawColumns(['checkbox', 'type', 'status', 'action'])
                ->make(true);
        }

        // ---------------- Dashboard Cards ---------------- //
        $cards = [
            'total' => Coupon::count(),
            'active' => Coupon::where('status', 1)->count(),
            'expired' => Coupon::whereDate('expires_at', '<', today())->count(),
            'upcoming' => Coupon::whereDate('starts_at', '>', today())->count(),
            'used' => Coupon::where('used', '>', 0)->count(),
            'redemptions' => Coupon::sum('used'),
        ];
        $title = 'Coupons';
        return view('admin.coupons.index', compact('title', 'cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Coupon';
        return view('admin.coupons.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'              => 'required|string|max:100|unique:coupons,code',
            'title'             => 'required|string|max:255',
            'type'              => 'required|in:fixed,percentage',
            'value'             => 'required|numeric|min:0',
            'minimum_amount'    => 'nullable|numeric|min:0',
            'maximum_discount'  => 'nullable|numeric|min:0',
            'usage_limit'       => 'nullable|integer|min:1',
            'starts_at'         => 'required|date',
            'expires_at'        => 'required|date|after_or_equal:starts_at',
            'status'            => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            Coupon::create([
                'code'              => strtoupper($request->code),
                'title'             => $request->title,
                'type'              => $request->type,
                'value'             => $request->value,
                'minimum_amount'    => $request->minimum_amount ?? 0,
                'maximum_discount'  => $request->maximum_discount,
                'usage_limit'       => $request->usage_limit,
                'used'              => 0,
                'starts_at'         => $request->starts_at,
                'expires_at'        => $request->expires_at,
                'status'            => $request->status ?? 0,
            ]);

            DB::commit();
            return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        $title = 'Coupon Details';
        return view('admin.coupons.show',compact('title','coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $title = 'Edit Coupon';
        return view('admin.coupons.edit', compact('title','coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validator = Validator::make($request->all(), [
            'code'              => 'required|string|max:100|unique:coupons,code,' . $coupon->id,
            'title'             => 'required|string|max:255',
            'type'              => 'required|in:fixed,percentage',
            'value'             => 'required|numeric|min:0',
            'minimum_amount'    => 'nullable|numeric|min:0',
            'maximum_discount'  => 'nullable|numeric|min:0',
            'usage_limit'       => 'nullable|integer|min:1',
            'starts_at'         => 'required|date',
            'expires_at'        => 'required|date|after_or_equal:starts_at',
            'status'            => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $coupon->update([
                'code'              => strtoupper($request->code),
                'title'             => $request->title,
                'type'              => $request->type,
                'value'             => $request->value,
                'minimum_amount'    => $request->minimum_amount ?? 0,
                'maximum_discount'  => $request->maximum_discount,
                'usage_limit'       => $request->usage_limit,
                // 'used' intentionally not updated
                // because it tracks actual coupon usage.
                'starts_at'         => $request->starts_at,
                'expires_at'        => $request->expires_at,
                'status'            => $request->status ?? 0,
            ]);

            DB::commit();
            return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Coupon $coupon)
    {
        DB::beginTransaction();
        try {
            $coupon->delete();

            DB::commit();
            if ($request->ajax()) {
                return response()->json([
                    'status'  => true,
                    'message' => 'Coupon deleted successfully.'
                ]);
            }

            return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
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
     * Bulk Delete Coupons
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids'   => 'required|array',
            'ids.*' => 'exists:coupons,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();

        try {
            Coupon::whereIn('id', $request->ids)->delete();

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Selected coupons deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change Coupon Status
     */
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'     => 'required|exists:coupons,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $coupon = Coupon::findOrFail($request->id);
            $coupon->update([
                'status' => $request->status
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'Coupon status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Coupon Code (AJAX)
     */
    public function generateCode()
    {
        do {
            $code = strtoupper('CPN-' . \Illuminate\Support\Str::random(8));
        } while (Coupon::where('code', $code)->exists());

        return response()->json([
            'status' => true,
            'code'   => $code,
        ]);
    }
}
