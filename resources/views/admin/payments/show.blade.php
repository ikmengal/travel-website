@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{---------------- Page Header ----------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-credit-card me-2 text-primary"></i>
                Payment Details
            </h4>
            <p class="text-muted mb-0">
                Complete payment information.
            </p>
        </div>
        <div>
            @can('payments-edit')
                <a href="{{ route('payments.edit',$payment->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan

            <a href="{{ route('payments.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{---------------- Left Side ----------------}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="ti ti-credit-card fs-2"></i>
                        </span>
                    </div>
                    <h4>
                        {{ $payment->payment_no }}
                    </h4>
                    <p class="text-muted">
                        {{ ucfirst(str_replace('_',' ',$payment->payment_method)) }}
                    </p>

                    <hr>
                    <table class="table table-borderless text-start">
                        <tr>
                            <th width="45%">Booking #</th>
                            <td>
                                {{ $payment->booking->booking_no }}
                            </td>
                        </tr>

                        <tr>
                            <th>Customer</th>
                            <td>
                                {{ $payment->booking->user->name ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Tour</th>
                            <td>
                                {{ $payment->booking->tour->title ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Amount</th>
                            <td>
                                {{ number_format($payment->amount,2) }}
                                {{ $payment->currency }}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                {!! paymentStatusBadge($payment->payment_status) !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Timeline
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Payment Date</th>
                            <td>
                                {{ optional($payment->payment_date)->format('d M Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Created</th>
                            <td>
                                {{ $payment->created_at->format('d M Y h:i A') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Updated</th>
                            <td>
                                {{ $payment->updated_at->format('d M Y h:i A') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{---------------- Right Side ----------------}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Payment Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Payment Number</label>
                            <p>
                                {{ $payment->payment_no }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Transaction ID</label>
                            <p>
                                {{ $payment->transaction_id ?: '-' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Payment Method</label>
                            <p>
                                {{ ucwords(str_replace('_',' ',$payment->payment_method)) }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Payment Gateway</label>
                            <p>
                                {{ $payment->gateway ?: '-' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Reference Number</label>
                            <p>
                                {{ $payment->reference_no ?: '-' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Amount</label>
                            <p>
                                {{ number_format($payment->amount) }}
                                {{ $payment->currency }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Receipt

                    </h5>

                </div>

                <div class="card-body text-center">

                    @if($payment->receipt)

                        @php
                            $extension = strtolower(pathinfo($payment->receipt, PATHINFO_EXTENSION));
                        @endphp

                        @if(in_array($extension,['jpg','jpeg','png','webp']))

                            <img src="{{ asset($payment->receipt) }}"
                                class="img-fluid rounded border"
                                style="max-height:450px;">

                        @else

                            <a href="{{ asset($payment->receipt) }}"
                                target="_blank"
                                class="btn btn-primary">

                                <i class="ti ti-download me-1"></i>

                                View Receipt

                            </a>

                        @endif

                    @else

                        <span class="badge bg-label-secondary">

                            No Receipt Uploaded

                        </span>

                    @endif

                </div>

            </div>

            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">

                        Notes

                    </h5>

                </div>

                <div class="card-body">

                    {!! $payment->notes ?: '<span class="text-muted">No notes available.</span>' !!}

                </div>

            </div>

        </div>
    </div>
@endsection
