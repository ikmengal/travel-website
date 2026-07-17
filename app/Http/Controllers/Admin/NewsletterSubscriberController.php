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
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Newsletter;


class NewsletterSubscriberController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        return [
            new Middleware('permission:newsletter-list', only :['index']),
            new Middleware('permission:newsletter-create', only :['create', 'store']),
            new Middleware('permission:newsletter-show', only :['show']),
            new Middleware('permission:newsletter-edit', only :['edit', 'update']),
            new Middleware('permission:newsletter-delete', only :['destroy', 'bulkDelete']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Newsletter::query();

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('verified')) {
                if ($request->verified == '1') {
                    $query->whereNotNull('verified_at');
                } else {
                    $query->whereNull('verified_at');
                }
            }

            if ($request->filled('subscribed_date')) {
                $query->whereDate('subscribed_at', $request->subscribed_date);
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return view('admin.newsletters.partials.checkbox', compact('row'));
                })
                ->editColumn('email', function ($row) {
                    return e($row->email);
                })
                ->editColumn('status', function ($row) {
                    return $this->statusBadge($row);
                })
                ->editColumn('verified_at', function ($row) {
                    return $row->verified_at
                        ? $row->verified_at->format('d M Y h:i A')
                        : '<span class="badge bg-label-warning">Pending</span>';
                })
                ->editColumn('subscribed_at', function ($row) {
                    return $row->subscribed_at ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return $this->actionColumn($row);
                })
                ->rawColumns(['checkbox', 'status', 'verified_at', 'action',])
                ->make(true);
        }
        return view('admin.newsletters.index');
    }

    /**
     * Status Badge
     */
    private function statusBadge($row)
    {
        if ($row->status) {
            return '
                <div class="form-check form-switch">
                    <input type="checkbox"
                           class="form-check-input changeStatus"
                           data-id="' . $row->id . '"
                           checked>
                </div>
            ';
        }

        return '
            <div class="form-check form-switch">
                <input type="checkbox"
                       class="form-check-input changeStatus"
                       data-id="' . $row->id . '">
            </div>
        ';
    }

    /**
     * Action Column
     */
    private function actionColumn($row)
    {
        return view('admin.newsletters.partials.action', compact('row'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.newsletters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'              => 'required|email:rfc,dns|max:255|unique:newsletters,email',
            'subscribed_at'      => 'nullable|date',
            'verified_at'        => 'nullable|date|after_or_equal:subscribed_at',
            'unsubscribed_at'    => 'nullable|date|after_or_equal:verified_at',
            'unsubscribe_reason' => 'nullable|string|max:1000',
            'status'             => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $status = $request->boolean('status');
            $subscriber = Newsletter::create([
                'email' => strtolower(trim($request->email)),
                'token' => Str::random(64),
                'status' => $status,
                'subscribed_at' => $request->subscribed_at ?: now(),
                'verified_at' => $status ? ($request->verified_at ?: now()) : null,
                'unsubscribed_at' => $status ? null : ($request->unsubscribed_at ?: now()),
                'unsubscribe_reason' => $status ? null : $request->unsubscribe_reason,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Newsletter subscriber created successfully.',
                'data'    => $subscriber,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Failed to create subscriber.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newsletter = Newsletter::where('id', $id)->first();
        return view('admin.newsletters.show', compact('newsletter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $newsletter = Newsletter::where('id', $id)->first();
        return view('admin.newsletters.edit', compact('newsletter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'email'              => 'required|email:rfc,dns|max:255|unique:newsletters,email,'.$id,
            'status'             => 'required|boolean',
            'subscribed_at'      => 'nullable|date',
            'verified_at'        => 'nullable|date|after_or_equal:subscribed_at',
            'unsubscribed_at'    => 'nullable|date|after_or_equal:verified_at',
            'unsubscribe_reason' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {

            $newsletter = Newsletter::where('id', $id)->first();

            if(empty($newsletter)){
                return response()->json([
                    'status'  => false,
                    'message' => 'Record not found.',
                    'errors'  => ['record not found'],
                ], 422);
            }

            $data = [
                'email'               => strtolower($request->email),
                'status'              => $request->boolean('status'),
                'unsubscribe_reason'  => $request->unsubscribe_reason,
                'subscribed_at'       => $request->filled('subscribed_at') ? $request->subscribed_at : $newsletter->subscribed_at,
                'ip_address'          => $newsletter->ip_address,
                'user_agent'          => $newsletter->user_agent,
                'token'               => $newsletter->token,
            ];

            /*
            |--------------------------------------------------------------------------
            | Verification Logic
            |--------------------------------------------------------------------------
            */

            if ($request->boolean('status')) {
                $data['verified_at'] = $request->filled('verified_at')
                    ? $request->verified_at
                    : ($newsletter->verified_at ?: now());

                $data['unsubscribed_at'] = null;
                $data['unsubscribe_reason'] = null;
            } else {
                $data['verified_at'] = $newsletter->verified_at;
                $data['unsubscribed_at'] = $request->filled('unsubscribed_at')
                    ? $request->unsubscribed_at
                    : ($newsletter->unsubscribed_at ?: now());
            }

            $newsletter->update($data);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Newsletter subscriber updated successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Failed to update subscriber.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsletter = Newsletter::where('id', $id)->first();

        if(empty($newsletter)){
            return response()->json([
                'status'  => false,
                'message' => 'Record not found.'
            ], 500);
        }

        try {
            $newsletter->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Newsletter subscriber deleted successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to delete subscriber.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Remove selected resources from storage.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:newsletters,id'],
        ]);

        DB::beginTransaction();

        try {
            $deleted = Newsletter::whereIn('id', $request->ids)->delete();
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Selected subscribers deleted successfully.',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Failed to delete selected subscribers.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Change subscriber status.
     */
    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:newsletters,id'],
        ]);

        try {
            $subscriber = Newsletter::findOrFail($request->id);
            $subscriber->status = ! $subscriber->status;
            if ($subscriber->status) {
                $subscriber->verified_at = $subscriber->verified_at ?: now();
                $subscriber->unsubscribed_at = null;
                $subscriber->unsubscribe_reason = null;
            } else {
                $subscriber->unsubscribed_at = now();
            }

            $subscriber->save();

            return response()->json([
                'status'  => true,
                'message' => 'Status updated successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to update status.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
