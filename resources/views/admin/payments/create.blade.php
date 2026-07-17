@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-------------- Page Header --------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-credit-card me-2 text-primary"></i>
                Add Payment
            </h4>

            <p class="text-muted mb-0">
                Create a new payment against a booking.
            </p>
        </div>
        <div>
            <a href="{{ route('payments.index') }}"
                class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
        @csrf
        <div class="row">
            {{-------------- Left Side --------------}}
            <div class="col-lg-8">
                {{-------------- Booking Information --------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Booking Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    Booking <span class="text-danger">*</span>
                                </label>
                                <select name="booking_id" id="booking_id" class="form-select select2 @error('booking_id') is-invalid @enderror">
                                    <option value="">Select Booking</option>
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                            {{ $booking->booking_no }}
                                            -
                                            {{ $booking->user->name ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('booking_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Customer</label>
                                <input type="text" id="customer_name" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tour</label>
                                <input type="text" id="tour_name" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grand Total</label>
                                <input type="text" id="booking_total" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Currency</label>
                                <input type="text" id="booking_currency" class="form-control"readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{-------------- Payment Information --------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Payment Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Number <span class="text-danger">*</span></label>
                                <input type="text" name="payment_no" class="form-control @error('payment_no') is-invalid @enderror"
                                    value="{{ old('payment_no', 'PAY-' . strtoupper(Str::random(8))) }}" readonly>

                                @error('payment_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Transaction ID</label>
                                <input type="text" name="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror"
                                    value="{{ old('transaction_id') }}" placeholder="Transaction ID">
                                @error('transaction_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Method <span class="text-danger">*</span> </label>
                                <select name="payment_method" class="form-select select2 @error('payment_method') is-invalid @enderror">
                                    <option value="">Select Method</option>
                                    <option value="cash" {{ old('payment_method')=='cash'?'selected':'' }}>Cash</option>
                                    <option value="bank_transfer" {{ old('payment_method')=='bank_transfer'?'selected':'' }}>Bank Transfer</option>
                                    <option value="credit_card" {{ old('payment_method')=='credit_card'?'selected':'' }}>Credit Card</option>
                                    <option value="debit_card" {{ old('payment_method')=='debit_card'?'selected':'' }}>Debit Card</option>
                                    <option value="paypal" {{ old('payment_method')=='paypal'?'selected':'' }}>PayPal</option>
                                    <option value="stripe" {{ old('payment_method')=='stripe'?'selected':'' }}>Stripe</option>
                                    <option value="jazzcash" {{ old('payment_method')=='jazzcash'?'selected':'' }}>JazzCash</option>
                                    <option value="easypaisa" {{ old('payment_method')=='easypaisa'?'selected':'' }}>EasyPaisa</option>
                                </select>

                                @error('payment_method')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Gateway</label>
                                <input type="text" name="payment_gateway" class="form-control @error('payment_gateway') is-invalid @enderror"
                                    value="{{ old('payment_gateway') }}" placeholder="e.g Stripe, HBL, Meezan">
                                @error('payment_gateway')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>

                                <input type="text" step="0.01" name="amount" id="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" placeholder="0.00">

                                @error('amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"> Currency </label>
                                <input type="text" name="currency" id="currency"
                                    class="form-control @error('currency') is-invalid @enderror"
                                    value="{{ old('currency') }}" placeholder="USD">

                                @error('currency')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Status <span class="text-danger">*</span> </label>
                                <select name="payment_status" class="form-select select2 @error('payment_status') is-invalid @enderror">
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid"{{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>

                                @error('payment_status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Date <span class="text-danger">*</span></label>

                                <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror"
                                    value="{{ old('payment_date', now()->format('Y-m-d')) }}">

                                @error('payment_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"> Reference Number </label>
                                <input type="text" name="reference_no" class="form-control @error('reference_no') is-invalid @enderror"
                                    value="{{ old('reference_no') }}" placeholder="Reference Number">
                                @error('reference_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"> Receipt </label>
                                <input type="file" name="receipt" class="form-control @error('receipt') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.pdf">

                                <small class="text-muted">
                                    Allowed: JPG, PNG, PDF (Max: 2MB)
                                </small>

                                @error('receipt')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" id="notes" rows="5"
                                    class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>

                                @error('notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-------------- Right Sidebar --------------}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Publish
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Active</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="status" value="1" {{ old('status',1) ? 'checked' : '' }}>
                                <label class="form-check-label"> Active Payment</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save Payment
                            </button>

                            <a href="{{ route('payments.index') }}" class="btn btn-label-secondary">
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
    @include('admin.payments.partials.create-script')
@endpush
