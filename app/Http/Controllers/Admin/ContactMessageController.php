<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\{
    HasMiddleware, Middleware
};
use Illuminate\Support\Facades\{
    Validator, DB, Mail
};
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    ContactMessage
};
use Illuminate\Validation\Rule;

class ContactMessageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:contacts-list', only: ['index']),
            new Middleware('permission:contacts-show', only: ['show']),
            new Middleware('permission:contacts-edit', only: [
                'changeStatus',
                'changeReadStatus',
                'changeReplyStatus',
            ]),
            new Middleware('permission:contacts-delete', only: [
                'destroy',
                'bulkDelete',
            ]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Contact Messages';
        // ------------------- Dashboard Cards ------------------- //
        // $cards = [
        //     'total' => ContactMessage::count(),
        //     'active' => ContactMessage::where('status', true)->count(),
        //     'inactive' => ContactMessage::where('status', false)->count(),
        //     'read' => ContactMessage::where('is_read', true)->count(),
        //     'unread' => ContactMessage::where('is_read', false)->count(),
        //     'replied' => ContactMessage::where('is_replied', true)->count(),
        //     'today' => ContactMessage::whereDate('created_at', today())->count(),
        // ];

        $cards = [
            'total'     => ContactMessage::count(),
            'unread'    => ContactMessage::where('is_read', false)->count(),
            'read'      => ContactMessage::where('is_read', true)->count(),
            'replied'   => ContactMessage::where('is_replied', true)->count(),
            'active'    => ContactMessage::where('status', true)->count(),
            'today'     => ContactMessage::whereDate('created_at', today())->count(),
        ];

        // ------------------- DataTable ------------------- //
        if ($request->ajax() && $request->loaddata == 'yes') {
            // $query = ContactMessage::with('user');
            $query = ContactMessage::with('user')
            ->latest();

            // ------------------- Filters ------------------- //
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('is_read')) {
                $query->where('is_read', $request->is_read);
            }

            if ($request->filled('is_replied')) {
                $query->where('is_replied', $request->is_replied);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return view('admin.contact_messages.partials.checkbox', compact('row'));
                })
                ->addColumn('user', function ($row) {
                    return view('admin.contact_messages.partials.user',compact('row'));
                })
                ->editColumn('name', function ($row) {
                    return e($row->name);
                })
                ->editColumn('email', function ($row) {
                    return e($row->email);
                })
                ->editColumn('subject', function ($row) {
                    return e($row->subject);
                    return Str::limit($row->subject, 40);
                })
                ->addColumn('read_status', function ($row) {
                    return view('admin.contact_messages.partials.read_status', compact('row'));
                })
                ->addColumn('reply_status', function ($row) {
                    return view('admin.contact_messages.partials.reply_status', compact('row'));
                })
                ->addColumn('status', function ($row) {
                    return view('admin.contact_messages.partials.status_badge',compact('row'));
                    // return $this->statusBadge($row);

                })
                ->editColumn('created_at', function ($row) {
                    // return $row->created_at
                    //     ? $row->created_at->format('d M Y h:i A')
                    //     : '-';

                    return '
                        <div>

                            <div class="fw-semibold">

                                '.$row->created_at->format('d M Y').'

                            </div>

                            <small class="text-muted">

                                '.$row->created_at->format('h:i A').'

                            </small>

                        </div>';
                })
                ->addColumn('action', function ($row) {
                    return view('admin.contact_messages.partials.action', compact('row'));
                })
                ->rawColumns([
                    'checkbox',
                    'user',
                    'read_status',
                    'reply_status',
                    'status',
                    'created_at',
                    'action'
                ])
                ->make(true);
        }
        return view('admin.contact_messages.index', compact('title','cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Contact Message Details';
        $message = ContactMessage::with('user')->find($id);

        if (!$message) {
            abort(404);
        }
        return view('admin.contact_messages.show', compact('title','message'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $message = ContactMessage::find($id);

            if (!$message) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Contact message not found.',
                ], 404);
            }

            $message->delete();
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Contact message deleted successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Failed to delete contact message.',
                'error'   => config('app.debug')
                    ? $e->getMessage()
                    : null,
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
            'ids.*' => ['required', 'exists:contact_messages,id'],
        ]);

        DB::beginTransaction();
        try {
            ContactMessage::whereIn('id', $request->ids)->delete();
            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Selected contact messages deleted successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Failed to delete selected contact messages.',
                'error'   => config('app.debug')
                    ? $e->getMessage()
                    : null,
            ], 500);
        }
    }

    /**
     * change Status the specified resource from storage.
     */
    // public function changeStatus(Request $request)
    // {
    //     $request->validate([
    //         'id'     => ['required', 'exists:contact_messages,id'],
    //         'status' => ['required', 'boolean'],
    //     ]);

    //     try {
    //         $message = ContactMessage::findOrFail($request->id);
    //         $message->update([
    //             'status' => $request->boolean('status'),
    //         ]);

    //         return response()->json([
    //             'status'  => true,
    //             'message' => 'Status updated successfully.',
    //         ]);
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => 'Failed to update status.',
    //             'error'   => config('app.debug')
    //                 ? $e->getMessage()
    //                 : null,
    //         ], 500);
    //     }
    // }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:contact_messages,id'],
            'status' => ['required', Rule::in([
                'new',
                'in_progress',
                'resolved',
                'closed'
            ])],
        ]);

        try {

            $message = ContactMessage::findOrFail($request->id);

            $message->update([
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully.',
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Failed to update status.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);

        }
    }

    /**
     * Change Read Status
     */
    public function changeReadStatus(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:contact_messages,id'],
        ]);

        try {
            $message = ContactMessage::findOrFail($request->id);
            $message->is_read = ! $message->is_read;

            if ($message->is_read) {
                $message->read_at = $message->read_at ?: now();
            } else {
                $message->read_at = null;
            }

            $message->save();

            return response()->json([
                'status'  => true,
                'message' => $message->is_read
                    ? 'Message marked as Read successfully.'
                    : 'Message marked as Unread successfully.',
                'is_read' => $message->is_read,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to update read status.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * change Reply Status the specified resource from storage.
     */
    public function changeReplyStatus(Request $request)
    {
        $request->validate([
            'id'          => ['required', 'exists:contact_messages,id'],
            'is_replied'  => ['required', 'boolean'],
        ]);

        try {
            $message = ContactMessage::findOrFail($request->id);
            $isReplied = $request->boolean('is_replied');

            $message->update([
                'is_replied' => $isReplied,
                'replied_at' => $isReplied ? ($message->replied_at ?: now()) : null,
            ]);

            return response()->json([
                'status'  => true,
                'message' => $isReplied
                    ? 'Message marked as replied successfully.'
                    : 'Reply status removed successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to update reply status.',
                'error'   => config('app.debug')
                    ? $e->getMessage()
                    : null,
            ], 500);
        }
    }

    // public function statusToggle($row)
    // {
    //     return '
    //     <label class="switch switch-success mb-0">
    //         <input
    //             type="checkbox"
    //             class="switch-input changeStatus"
    //             data-id="'.$row->id.'"
    //             '.($row->status ? 'checked' : '').'>
    //         <span class="switch-toggle-slider">
    //             <span class="switch-on">
    //                 <i class="ti ti-check"></i>
    //             </span>
    //             <span class="switch-off">
    //                 <i class="ti ti-x"></i>
    //             </span>
    //         </span>

    //         <span class="switch-label fw-semibold '.($row->status ? 'text-success' : 'text-danger').'">
    //             '.($row->status ? 'Active' : 'Inactive').'
    //         </span>
    //     </label>';
    // }

    public function statusBadge($row)
    {
        $badges = [
            'new' => 'secondary',
            'in_progress' => 'warning',
            'resolved' => 'success',
            'closed' => 'danger',
        ];

        $labels = [
            'new' => 'New',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
        ];

        $html = '<select class="form-select select2 form-select-sm changeStatus"
                    data-id="'.$row->id.'">';

        foreach ($labels as $value => $label) {

            $selected = $row->status == $value ? 'selected' : '';

            $html .= '<option value="'.$value.'" '.$selected.'>
                        '.$label.'
                    </option>';
        }

        $html .= '</select>';

        return $html;
    }

    public function getReply(Request $request)
    {
        $message = ContactMessage::findOrFail($request->id);

        return response()->json([
            'status'=>true,
            'data'=>$message
        ]);
    }

    /**
     * Send Reply
     */
    public function sendReply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'    => ['required', 'exists:contact_messages,id'],
            'reply' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $message = ContactMessage::findOrFail($request->id);
            if ($message->is_replied) {
                return response()->json([
                    'status' => false,
                    'message' => 'This message has already been replied.'
                ], 422);
            }

            // Mail::to($message->email)->send(new ContactReplyMail($message, $request->reply));

            $message->update([
                'message_reply' => $request->reply,
                'is_replied' => true,
                'replied_at' => now(),
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Reply sent successfully.'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to send reply.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : null,
            ], 500);
        }
    }

    public function viewReply(Request $request)
    {
        $message = ContactMessage::findOrFail($request->id);
        return response()->json([
            'status' => true,
            'data' => [
                'id' => $message->id,
                'name' => $message->name,
                'email' => $message->email,
                'subject' => $message->subject,
                'message' => $message->message,
                'reply_message' => $message->message_reply,
            ]
        ]);
    }
}
