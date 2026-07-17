@extends('admin.layouts.app')
@section('title', 'Newsletter Subscriber Details')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Newsletter Subscriber Details</h4>
            <p class="text-muted mb-0">
                View newsletter subscriber information.
            </p>
        </div>
        <div>
            @can('newsletters-edit')
                <a href="{{ route('newsletter_subscribers.edit',$newsletter->id) }}"
                    class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan
            <a href="{{ route('newsletter_subscribers.index') }}"
                class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Subscriber Information --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Subscriber Information</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="220">Email</th>
                                <td>{{ $newsletter->email }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($newsletter->status)
                                        <span class="badge bg-label-success">
                                            Subscribed
                                        </span>
                                    @else
                                        <span class="badge bg-label-danger">
                                            Unsubscribed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Verification</th>
                                <td>
                                    @if($newsletter->verified_at)
                                        <span class="badge bg-label-success">
                                            Verified
                                        </span>
                                    @else
                                        <span class="badge bg-label-warning">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Subscribed At</th>
                                <td>
                                    {{ optional($newsletter->subscribed_at)->format('d M Y h:i A') ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Verified At</th>
                                <td>
                                    {{ optional($newsletter->verified_at)->format('d M Y h:i A') ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Unsubscribed At</th>
                                <td>
                                    {{ optional($newsletter->unsubscribed_at)->format('d M Y h:i A') ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Unsubscribe Reason</th>
                                <td>
                                    {{ $newsletter->unsubscribe_reason ?: '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- System Information --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">System Information</h5>
                </div>

                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th width="130">ID</th>
                                <td>#{{ $newsletter->id }}</td>
                            </tr>
                            <tr>
                                <th>Token</th>
                                <td>
                                    <small class="text-break">
                                        {{ $newsletter->token }}
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td>{{ $newsletter->ip_address ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>User Agent</th>
                                <td>
                                    <small class="text-break">
                                        {{ $newsletter->user_agent ?: '-' }}
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>
                                    {{ optional($newsletter->created_at)->format('d M Y h:i A') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>
                                    {{ optional($newsletter->updated_at)->format('d M Y h:i A') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
