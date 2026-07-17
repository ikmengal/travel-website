@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{--------------- Page Header ---------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-credit-card me-2 text-primary"></i>
                Edit Payment
            </h4>
            <p class="text-muted mb-0">
                Update payment information.
            </p>
        </div>
        <div>
            <a href="{{ route('payments.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <form action="{{ route('payments.update',$payment->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
        @csrf
        @method('PUT')

        <div class="row">
            {{--------------- Left Side ---------------}}
            <div class="col-lg-8">
                {{--------------- Booking Information ---------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Booking Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label"> Booking <span class="text-danger">*</span></label>

                                <select name="booking_id" id="booking_id" class="form-select select2 @error('booking_id') is-invalid @enderror">
                                    <option value=""> Select Booking </option>
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" {{ old('booking_id',$payment->booking_id)==$booking->id ? 'selected' : '' }}>
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
                                <input type="text" id="customer_name" class="form-control"
                                    value="{{ $payment->booking->user->name ?? '' }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tour</label>
                                <input type="text" id="tour_name" class="form-control"
                                    value="{{ $payment->booking->tour->title ?? '' }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grand Total</label>
                                <input type="text" id="booking_total" class="form-control"
                                    value="{{ $payment->booking->grand_total }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Currency</label>
                                <input type="text" id="booking_currency" class="form-control"
                                    value="{{ $payment->booking->currency }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{--------------- Payment Information ---------------}}
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
                                    value="{{ old('payment_no', $payment->payment_no) }}" readonly>

                                @error('payment_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Transaction ID</label>
                                <input type="text" name="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror"
                                    value="{{ old('transaction_id', $payment->transaction_id) }}" placeholder="Transaction ID">
                                @error('transaction_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select select2 @error('payment_method') is-invalid @enderror">
                                    <option value="">Select Method</option>
                                    <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                    <option value="debit_card" {{ old('payment_method', $payment->payment_method) == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                                    <option value="paypal" {{ old('payment_method', $payment->payment_method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="stripe" {{ old('payment_method', $payment->payment_method) == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                    <option value="jazzcash" {{ old('payment_method', $payment->payment_method) == 'jazzcash' ? 'selected' : '' }}>JazzCash</option>
                                    <option value="easypaisa" {{ old('payment_method', $payment->payment_method) == 'easypaisa' ? 'selected' : '' }}>EasyPaisa</option>
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
                                    value="{{ old('payment_gateway', $payment->gateway) }}" placeholder="Payment Gateway">
                                @error('payment_gateway')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="text" step="0.01" name="amount" id="amount"
                                    class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $payment->amount) }}">
                                @error('amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Currency</label>
                                <input type="text" name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror"
                                    value="{{ old('currency', $payment->currency) }}">
                                @error('currency')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Status <span class="text-danger">*</span></label>
                                <select name="payment_status" class="form-select select2 @error('payment_status') is-invalid @enderror">
                                    <option value="">Select Status</option>
                                    <option value="pending"
                                        {{ old('payment_status', $payment->payment_status) == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="paid"
                                        {{ old('payment_status', $payment->payment_status) == 'paid' ? 'selected' : '' }}>
                                        Paid
                                    </option>
                                    <option value="failed"
                                        {{ old('payment_status', $payment->payment_status) == 'failed' ? 'selected' : '' }}>
                                        Failed
                                    </option>
                                    <option value="refunded"
                                        {{ old('payment_status', $payment->payment_status) == 'refunded' ? 'selected' : '' }}>
                                        Refunded
                                    </option>
                                    <option value="cancelled"
                                        {{ old('payment_status', $payment->payment_status) == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
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
                                    value="{{ old('payment_date', $payment->paid_at) }}">
                                @error('payment_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Reference Number</label>
                                <input type="text" name="reference_no" class="form-control @error('reference_no') is-invalid @enderror"
                                    value="{{ old('reference_no', $payment->reference_no) }}" placeholder="Reference Number">
                                @error('reference_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Receipt</label>
                                <input type="file" name="receipt" class="form-control @error('receipt') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                @error('receipt')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if($payment->receipt)
                                    <div class="mt-3">
                                        @php
                                            $extension = pathinfo($payment->receipt, PATHINFO_EXTENSION);
                                        @endphp
                                        @if(in_array(strtolower($extension), ['jpg','jpeg','png','webp']))
                                            <img src="{{ asset($payment->receipt) }}" class="img-fluid rounded border" style="max-height:180px;">
                                        @else
                                            <a href="{{ asset($payment->receipt) }}" target="_blank" class="btn btn-label-primary">
                                                <i class="ti ti-file"></i>
                                                View Current Receipt
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" id="notes" rows="5"
                                    class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $payment->notes) }}</textarea>
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

            {{--------------- Right Sidebar ---------------}}
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
                                <input class="form-check-input" type="checkbox" name="status" value="1"
                                    {{ old('status', $payment->status) ? 'checked' : '' }}>
                                <label class="form-check-label">Active Payment</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Update Payment
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
    @include('admin.payments.partials.edit-script')
@endpush
