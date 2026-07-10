@extends('admin.layouts.app')

@section('title', $title)

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- ========================================== --}}
    {{-- Page Header --}}
    {{-- ========================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="ti ti-edit me-2 text-primary"></i>

                Edit Booking

            </h4>

            <p class="text-muted mb-0">

                Update booking information.

            </p>

        </div>

        <div>

            <a href="{{ route('bookings.index') }}"
                class="btn btn-outline-secondary">

                <i class="ti ti-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <form id="bookingForm"
        action="{{ route('bookings.update', $booking->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="row">

            {{-- ========================================== --}}
            {{-- LEFT SIDE --}}
            {{-- ========================================== --}}

            <div class="col-lg-8">

                {{-- Booking Information --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Booking Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Customer --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Customer

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    id="user_id"
                                    name="user_id"
                                    class="form-select select2 @error('user_id') is-invalid @enderror">

                                    <option value="">

                                        Select Customer

                                    </option>

                                    @foreach($users as $user)

                                        <option
                                            value="{{ $user->id }}"
                                            {{ old('user_id', $booking->user_id) == $user->id ? 'selected' : '' }}>

                                            {{ $user->name }}
                                            ({{ $user->email }})

                                        </option>

                                    @endforeach

                                </select>

                                @error('user_id')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            {{-- Tour --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Tour

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    id="tour_id"
                                    name="tour_id"
                                    class="form-select select2 @error('tour_id') is-invalid @enderror">

                                    <option value="">

                                        Select Tour

                                    </option>

                                    @foreach($tours as $tour)

                                        <option
                                            value="{{ $tour->id }}"
                                            data-price="{{ $tour->price }}"
                                            {{ old('tour_id', $booking->tour_id) == $tour->id ? 'selected' : '' }}>

                                            {{ $tour->title }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- Departure --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Departure

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    id="tour_departure_id"
                                    name="tour_departure_id"
                                    class="form-select select2">

                                    @if($booking->departure)

                                        <option
                                            value="{{ $booking->departure->id }}"
                                            selected>

                                            {{ $booking->departure->departure_date }}
                                            →
                                            {{ $booking->departure->return_date }}

                                        </option>

                                    @else

                                        <option value="">

                                            Select Departure

                                        </option>

                                    @endif

                                </select>

                            </div>

                            {{-- Booking Number --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Booking Number

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $booking->booking_no }}"
                                    readonly>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ========================================== --}}
                {{-- Travelers --}}
                {{-- ========================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Travelers Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Adults --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Adults

                                </label>

                                <input
                                    type="number"
                                    min="1"
                                    id="adults"
                                    name="adults"
                                    value="{{ old('adults', $booking->adults) }}"
                                    class="form-control">

                            </div>

                            {{-- Children --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Children

                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    id="children"
                                    name="children"
                                    value="{{ old('children', $booking->children) }}"
                                    class="form-control">

                            </div>

                            {{-- Infants --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Infants

                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    id="infants"
                                    name="infants"
                                    value="{{ old('infants', $booking->infants) }}"
                                    class="form-control">

                            </div>

                            {{-- Total Travelers --}}
                            <div class="col-md-12">

                                <label class="form-label">

                                    Total Travelers

                                </label>

                                <input
                                    type="text"
                                    id="total_travelers"
                                    class="form-control"
                                    value="{{ $booking->total_travelers }}"
                                    readonly>

                            </div>

                        </div>

                    </div>

                </div>

                                {{-- ========================================== --}}
                {{-- Pricing Information --}}
                {{-- ========================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Pricing Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Tour Price --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Tour Price

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        $

                                    </span>

                                    <input
                                        type="number"
                                        step="0.01"
                                        id="tour_price"
                                        name="tour_price"
                                        value="{{ old('tour_price', $booking->tour_price) }}"
                                        class="form-control @error('tour_price') is-invalid @enderror"
                                        readonly>

                                </div>

                                @error('tour_price')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            {{-- Subtotal --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Subtotal

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        $

                                    </span>

                                    <input
                                        type="number"
                                        step="0.01"
                                        id="subtotal"
                                        name="subtotal"
                                        value="{{ old('subtotal', $booking->subtotal) }}"
                                        class="form-control"
                                        readonly>

                                </div>

                            </div>

                            {{-- Discount --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Discount

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        $

                                    </span>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="discount"
                                        name="discount"
                                        value="{{ old('discount', $booking->discount) }}"
                                        class="form-control">

                                </div>

                            </div>

                            {{-- Tax --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Tax

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        $

                                    </span>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="tax"
                                        name="tax"
                                        value="{{ old('tax', $booking->tax) }}"
                                        class="form-control">

                                </div>

                            </div>

                            {{-- Grand Total --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Grand Total

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        $

                                    </span>

                                    <input
                                        type="number"
                                        step="0.01"
                                        id="grand_total"
                                        name="grand_total"
                                        value="{{ old('grand_total', $booking->grand_total) }}"
                                        class="form-control fw-bold bg-label-primary"
                                        readonly>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ========================================== --}}
                {{-- Special Request --}}
                {{-- ========================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Special Request

                        </h5>

                    </div>

                    <div class="card-body">

                        <textarea
                            name="special_request"
                            id="special_request"
                            rows="6"
                            class="form-control @error('special_request') is-invalid @enderror">{{ old('special_request', $booking->special_request) }}</textarea>

                        @error('special_request')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

                        {{-- ========================================== --}}
            {{-- RIGHT SIDEBAR --}}
            {{-- ========================================== --}}

            <div class="col-lg-4">

                {{-- Booking Status --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Booking Status

                        </h5>

                    </div>

                    <div class="card-body">

                        {{-- Booking Status --}}
                        <div class="mb-3">

                            <label class="form-label">

                                Booking Status

                            </label>

                            <select
                                name="booking_status"
                                class="form-select @error('booking_status') is-invalid @enderror">

                                <option value="pending"
                                    {{ old('booking_status', $booking->booking_status) == 'pending' ? 'selected' : '' }}>

                                    Pending

                                </option>

                                <option value="confirmed"
                                    {{ old('booking_status', $booking->booking_status) == 'confirmed' ? 'selected' : '' }}>

                                    Confirmed

                                </option>

                                <option value="completed"
                                    {{ old('booking_status', $booking->booking_status) == 'completed' ? 'selected' : '' }}>

                                    Completed

                                </option>

                                <option value="cancelled"
                                    {{ old('booking_status', $booking->booking_status) == 'cancelled' ? 'selected' : '' }}>

                                    Cancelled

                                </option>

                                <option value="refunded"
                                    {{ old('booking_status', $booking->booking_status) == 'refunded' ? 'selected' : '' }}>

                                    Refunded

                                </option>

                            </select>

                        </div>

                        {{-- Payment Status --}}
                        <div class="mb-3">

                            <label class="form-label">

                                Payment Status

                            </label>

                            <select
                                name="payment_status"
                                class="form-select @error('payment_status') is-invalid @enderror">

                                <option value="pending"
                                    {{ old('payment_status', $booking->payment_status) == 'pending' ? 'selected' : '' }}>

                                    Pending

                                </option>

                                <option value="paid"
                                    {{ old('payment_status', $booking->payment_status) == 'paid' ? 'selected' : '' }}>

                                    Paid

                                </option>

                                <option value="failed"
                                    {{ old('payment_status', $booking->payment_status) == 'failed' ? 'selected' : '' }}>

                                    Failed

                                </option>

                                <option value="refunded"
                                    {{ old('payment_status', $booking->payment_status) == 'refunded' ? 'selected' : '' }}>

                                    Refunded

                                </option>

                            </select>

                        </div>

                        {{-- Currency --}}
                        <div class="mb-3">

                            <label class="form-label">

                                Currency

                            </label>

                            <select
                                name="currency"
                                class="form-select">

                                <option value="PKR"
                                    {{ old('currency', $booking->currency) == 'PKR' ? 'selected' : '' }}>

                                    PKR

                                </option>

                                <option value="USD"
                                    {{ old('currency', $booking->currency) == 'USD' ? 'selected' : '' }}>

                                    USD

                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                {{-- Booking Summary --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Booking Summary

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-sm">

                            <tbody>

                                <tr>

                                    <th>Total Travelers</th>

                                    <td class="text-end">

                                        <span id="summaryTravelers">

                                            {{ $booking->total_travelers }}

                                        </span>

                                    </td>

                                </tr>

                                <tr>

                                    <th>Tour Price</th>

                                    <td class="text-end">

                                        <span id="summaryPrice">

                                            {{ number_format($booking->tour_price,2) }}

                                        </span>

                                    </td>

                                </tr>

                                <tr>

                                    <th>Discount</th>

                                    <td class="text-end text-danger">

                                        <span id="summaryDiscount">

                                            {{ number_format($booking->discount,2) }}

                                        </span>

                                    </td>

                                </tr>

                                <tr>

                                    <th>Tax</th>

                                    <td class="text-end">

                                        <span id="summaryTax">

                                            {{ number_format($booking->tax,2) }}

                                        </span>

                                    </td>

                                </tr>

                                <tr class="table-primary">

                                    <th>

                                        Grand Total

                                    </th>

                                    <th class="text-end">

                                        <span id="summaryGrandTotal">

                                            {{ number_format($booking->grand_total,2) }}

                                        </span>

                                    </th>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- Submit --}}
                <div class="card">

                    <div class="card-body">

                        <div class="d-grid gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="ti ti-device-floppy me-1"></i>

                                Update Booking

                            </button>

                            <a href="{{ route('bookings.index') }}"
                                class="btn btn-outline-secondary">

                                Cancel

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('js')

    @include('admin.bookings.edit-script')

@endpush
