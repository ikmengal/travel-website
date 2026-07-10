@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{--------------- Page Header ---------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-ticket me-2 text-primary"></i>
                Create Booking
            </h4>
            <p class="text-muted mb-0">
                Create a new tour booking for customer.
            </p>
        </div>

        <div>
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <div class="row">
            {{--------------- LEFT SIDE---------------}}
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
                                <label class="form-label">Customer <span class="text-danger">*</span></label>
                                <select id="user_id" name="user_id"
                                    class="form-select select2 @error('user_id') is-invalid @enderror">
                                    <option value="">Select Customer</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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

                                <select id="tour_id" name="tour_id"
                                    class="form-select select2 @error('tour_id') is-invalid @enderror">

                                    <option value="">
                                        Select Tour
                                    </option>
                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}" data-price="{{ $tour->price }}"
                                            {{ old('tour_id') == $tour->id ? 'selected' : '' }}>
                                            {{ $tour->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Departure --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label"> Departure <span class="text-danger">*</span> </label>

                                <select id="tour_departure_id" name="tour_departure_id" class="form-select select2">
                                    <option value="">
                                        Select Departure
                                    </option>
                                </select>
                            </div>

                            {{-- Booking Number --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Booking Number</label>
                                <input type="text" class="form-control" value="Auto Generate" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{--------------- Travelers ---------------}}
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
                                <label class="form-label">Adults</label>
                                <input type="number" min="1" id="adults" name="adults" value="{{ old('adults',1) }}" class="form-control">
                            </div>

                            {{-- Children --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Children</label>
                                <input type="number" min="0" id="children" name="children" value="{{ old('children',0) }}" class="form-control">
                            </div>

                            {{-- Infants --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Infants</label>
                                <input type="number" min="0" id="infants" name="infants" value="{{ old('infants',0) }}" class="form-control">
                            </div>

                            {{-- Total Travelers --}}
                            <div class="col-md-12">
                                <label class="form-label">Total Travelers</label>
                                <input type="text" id="total_travelers" class="form-control" value="1" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{--------------- Pricing Information ---------------}}
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
                                <label class="form-label">Tour Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" id="tour_price" name="tour_price" value="{{ old('tour_price',0) }}"
                                        class="form-control @error('tour_price') is-invalid @enderror" readonly>
                                </div>

                                @error('tour_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Sub Total --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Subtotal</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" id="subtotal" name="subtotal" value="{{ old('subtotal',0) }}"
                                        class="form-control @error('subtotal') is-invalid @enderror" readonly>
                                </div>
                            </div>

                            {{-- Discount --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Discount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" id="discount" name="discount"
                                        value="{{ old('discount',0) }}" class="form-control @error('discount') is-invalid @enderror">
                                </div>
                            </div>

                            {{-- Tax --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tax</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" id="tax"
                                        name="tax" value="{{ old('tax',0) }}"
                                        class="form-control @error('tax') is-invalid @enderror">
                                </div>
                            </div>

                            {{-- Grand Total --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grand Total</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" id="grand_total" name="grand_total"
                                        value="{{ old('grand_total',0) }}" readonly
                                        class="form-control fw-bold bg-label-primary @error('grand_total') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--------------- Special Request ---------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Special Request
                        </h5>
                    </div>

                    <div class="card-body">
                        <textarea name="special_request" id="special_request" rows="6"
                            class="form-control @error('special_request') is-invalid @enderror"
                            placeholder="Write customer's special request here...">{{ old('special_request') }}</textarea>

                        @error('special_request')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{--------------- RIGHT SIDEBAR ---------------}}
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
                            <label class="form-label">Booking Status</label>
                            <select name="booking_status" class="form-select @error('booking_status') is-invalid @enderror">
                                <option value="pending" {{ old('booking_status','pending') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="confirmed" {{ old('booking_status') == 'confirmed' ? 'selected' : '' }}>
                                    Confirmed
                                </option>
                                <option value="completed" {{ old('booking_status') == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled" {{ old('booking_status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                                <option value="refunded" {{ old('booking_status') == 'refunded' ? 'selected' : '' }}>
                                    Refunded
                                </option>
                            </select>
                        </div>

                        {{-- Payment Status --}}
                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror">
                                <option value="pending" {{ old('payment_status','pending') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>
                                    Paid
                                </option>
                                <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>
                                    Failed
                                </option>
                                <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>
                                    Refunded
                                </option>
                            </select>
                        </div>

                        {{-- Currency --}}
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <select name="currency" class="form-select">
                                <option value="PKR" {{ old('currency','PKR') == 'PKR' ? 'selected' : '' }}>
                                    PKR
                                </option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>
                                    USD
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Booking Summary
                        </h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <th>Total Travelers</th>
                                <td class="text-end">
                                    <span id="summaryTravelers">1</span>
                                </td>
                            </tr>

                            <tr>
                                <th>Tour Price</th>
                                <td class="text-end">
                                    <span id="summaryPrice">0.00</span>
                                </td>
                            </tr>

                            <tr>
                                <th>Discount</th>
                                <td class="text-end text-danger">
                                    <span id="summaryDiscount">0.00</span>
                                </td>
                            </tr>

                            <tr>
                                <th>Tax</th>
                                <td class="text-end">
                                    <span id="summaryTax">0.00</span>
                                </td>
                            </tr>

                            <tr class="table-primary">
                                <th>
                                    Grand Total
                                </th>
                                <th class="text-end">
                                    <span id="summaryGrandTotal">0.00</span>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save Booking
                            </button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    @include('admin.bookings.create-script')
@endpush
