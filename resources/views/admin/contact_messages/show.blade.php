@extends('admin.layouts.app')

@section('title', $title)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-mail text-primary me-2"></i>
            {{ $title }}
        </h4>

        <p class="text-muted mb-0">
            View complete contact message information.
        </p>
    </div>

    <a href="{{ route('contact_messages.index') }}" class="btn btn-outline-secondary">
        <i class="ti ti-arrow-left me-1"></i>
        Back
    </a>
</div>

<div class="row">

    {{-- LEFT --}}
    <div class="col-lg-8">

        {{-- Customer --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ti ti-user me-2 text-primary"></i>
                    Customer Information
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Name</label>

                        <div class="fw-semibold">
                            {{ $message->name }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>

                        <div>
                            <a href="mailto:{{ $message->email }}">
                                {{ $message->email }}
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Phone</label>

                        <div>
                            {{ $message->phone ?: '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Subject</label>

                        <div class="fw-semibold">
                            {{ $message->subject }}
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- Customer Message --}}
        <div class="card mb-4">

            <div class="card-header">
                <h5 class="mb-0">

                    <i class="ti ti-message me-2 text-success"></i>

                    Customer Message

                </h5>
            </div>

            <div class="card-body">
                <div class="border rounded p-3 bg-lighter"
                    style="white-space:pre-wrap;min-height:180px">{!! nl2br(e($message->message)) !!}</div>
            </div>

        </div>

        {{-- Reply --}}
        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="ti ti-arrow-back-up text-info me-2"></i>

                    Admin Reply

                </h5>

            </div>

            <div class="card-body">

                @if($message->message_reply)
                    <div class="border rounded p-3 bg-lighter"
                        style="white-space:pre-wrap;min-height:180px">{!! $message->message_reply !!}</div>
                @else

                    <div class="text-center py-5">

                        <i class="ti ti-mail-off fs-1 text-muted"></i>

                        <h6 class="mt-3">

                            No reply has been sent yet.

                        </h6>

                    </div>

                @endif

            </div>

        </div>

    </div>

    {{-- RIGHT --}}
    <div class="col-lg-4">
        {{-- Status --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ti ti-badge me-2 text-warning"></i>
                    Status
                </h5>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span>Status</span>
                    {!! messageStatusBadge($message->status) !!}
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Read</span>
                    {!! readBadge($message->is_read) !!}
                </div>
                <div class="d-flex justify-content-between">
                    <span>Reply</span>
                    {!! replyBadge($message->is_replied) !!}
                </div>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="card mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="ti ti-clock me-2 text-primary"></i>

                    Timeline

                </h5>

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <small class="text-muted d-block">

                        Received

                    </small>

                    <strong>

                        {{ optional($message->created_at)->format('d M Y h:i A') }}

                    </strong>

                </div>

                <div class="mb-3">

                    <small class="text-muted d-block">

                        Read At

                    </small>

                    <strong>

                        {{ optional($message->read_at)->format('d M Y h:i A') ?: '-' }}

                    </strong>

                </div>

                <div>

                    <small class="text-muted d-block">

                        Replied At

                    </small>

                    <strong>

                        {{ optional($message->replied_at)->format('d M Y h:i A') ?: '-' }}

                    </strong>

                </div>

            </div>

        </div>

        {{-- System --}}
        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="ti ti-server me-2 text-danger"></i>

                    System Information

                </h5>

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <small class="text-muted d-block">

                        User

                    </small>

                    <strong>

                        {{ optional($message->user)->name ?? 'Guest User' }}

                    </strong>

                </div>

                <div class="mb-3">

                    <small class="text-muted d-block">

                        IP Address

                    </small>

                    <strong>

                        {{ $message->ip_address ?: '-' }}

                    </strong>

                </div>

                <div>

                    <small class="text-muted d-block">

                        User Agent

                    </small>

                    <div style="word-break:break-word">

                        {{ $message->user_agent ?: '-' }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
