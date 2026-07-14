@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-eye ti-md me-2 text-primary"></i>
                Booking Details
            </h4>
            <p class="text-muted mb-0">
                Complete booking information.
            </p>
        </div>

        <div>
            @can('bookings-edit')
                <a href="{{ route('bookings.edit',$booking->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- LEFT SIDE --}}
        <div class="col-lg-8">
            {{-- Booking Information --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Booking Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="220">
                                    Booking No
                                </th>
                                <td>
                                    {{ $booking->booking_no }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Customer
                                </th>
                                <td>
                                    {{ $booking->user->name ?? '-' }}
                                    <br>
                                    <small class="text-muted">
                                        {{ $booking->user->email ?? '' }}
                                    </small>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Tour
                                </th>
                                <td>
                                    {{ $booking->tour->title ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Departure Date
                                </th>
                                <td>
                                    {{ optional($booking->departure)->departure_date }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Return Date
                                </th>
                                <td>
                                    {{ optional($booking->departure)->return_date }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Travelers --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Travelers Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="220">
                                    Adults
                                </th>
                                <td>
                                    {{ $booking->adults }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Children
                                </th>
                                <td>
                                    {{ $booking->children }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Infants
                                </th>
                                <td>
                                    {{ $booking->infants }}
                                </td>
                            </tr>

                            <tr class="table-primary">
                                <th>
                                    Total Travelers
                                </th>
                                <td>
                                    <strong>
                                        {{ $booking->total_travelers }}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pricing Information --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Pricing Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="220">
                                    Tour Price
                                </th>
                                <td>
                                    {{ number_format($booking->tour_price,2) }}
                                    {{ $booking->currency }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Subtotal
                                </th>
                                <td>
                                    {{ number_format($booking->subtotal,2) }}
                                    {{ $booking->currency }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Discount
                                </th>
                                <td class="text-danger">
                                    - {{ number_format($booking->discount,2) }}
                                    {{ $booking->currency }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Tax
                                </th>
                                <td>
                                    {{ number_format($booking->tax,2) }}
                                    {{ $booking->currency }}
                                </td>
                            </tr>

                            <tr class="table-success">
                                <th>
                                    Grand Total
                                </th>
                                <td>
                                    <strong>
                                        {{ number_format($booking->grand_total,2) }}
                                        {{ $booking->currency }}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Special Request --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Special Request
                    </h5>
                </div>

                <div class="card-body">
                    @if($booking->special_request)
                        {!! $booking->special_request !!}
                    @else
                        <span class="text-muted">
                            No special request available.
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="col-lg-4">
            {{-- Status --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Booking Status
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>
                                    Booking
                                </th>
                                <td class="text-end">
                                    {!! bookingStatusBadge($booking->booking_status) !!}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Payment
                                </th>
                                <td class="text-end">
                                    {!! paymentStatusBadge($booking->payment_status) !!}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Currency
                                </th>
                                <td class="text-end">
                                    {{ $booking->currency }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Booking Timeline --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Booking Timeline
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="140">
                                    Created At
                                </th>
                                <td>
                                    {{ $booking->created_at?->format('d M Y h:i A') }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Updated At
                                </th>
                                <td>
                                    {{ $booking->updated_at?->format('d M Y h:i A') }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Confirmed
                                </th>
                                <td>
                                    {{ $booking->confirmed_at ? $booking->confirmed_at->format('d M Y h:i A') : '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Completed
                                </th>
                                <td>
                                    {{ $booking->completed_at ? $booking->completed_at->format('d M Y h:i A') : '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Cancelled
                                </th>
                                <td>
                                    {{ $booking->cancelled_at ? $booking->cancelled_at->format('d M Y h:i A') : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Quick Summary --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Booking Summary
                    </h5>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Travelers</span>
                        <strong>{{ $booking->total_travelers }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tour Price</span>
                        <strong>{{ number_format($booking->tour_price,2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount</span>
                        <strong class="text-danger">
                            -{{ number_format($booking->discount,2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <strong>{{ number_format($booking->tax,2) }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0">
                            Grand Total
                        </h5>
                        <h5 class="mb-0 text-primary">
                            {{ number_format($booking->grand_total,2) }}
                            {{ $booking->currency }}
                        </h5>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @can('bookings-edit')
                            <a href="{{ route('bookings.edit',$booking->id) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>
                                Edit Booking
                            </a>
                        @endcan
                        @can('bookings-list')
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-list me-1"></i>
                                Back to List
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
