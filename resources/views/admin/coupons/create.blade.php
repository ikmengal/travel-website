@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{------------ Page Header ------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-ticket me-2 text-primary"></i>
                Create Coupon
            </h4>
            <p class="text-muted mb-0">
                Create a new discount coupon.
            </p>
        </div>

        <div>
            <a href="{{ route('coupons.index') }}"class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <form id="couponForm" action="{{ route('coupons.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Left Side --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Coupon Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Coupon Code --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code') }}" placeholder="SUMMER2026">

                                    <button class="btn btn-outline-primary" type="button" id="generateCode">
                                        Generate
                                    </button>
                                </div>

                                @error('code')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Title --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Coupon Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}" placeholder="Summer Discount">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Discount Type --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select select2 @error('type') is-invalid @enderror">
                                    <option value="">Select Type</option>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                    <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage </option>
                                </select>

                                @error('type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Discount Value --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" name="value" id="value"
                                    class="form-control @error('value') is-invalid @enderror"
                                    value="{{ old('value') }}" placeholder="0.00">
                                @error('value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Minimum Booking Amount --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Booking Amount</label>
                                <input type="number" step="0.01" min="0" name="minimum_amount"
                                    class="form-control @error('minimum_amount') is-invalid @enderror"
                                    value="{{ old('minimum_amount',0) }}" placeholder="0.00">

                                @error('minimum_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Maximum Discount --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Maximum Discount</label>
                                <input type="number" step="0.01" min="0" id="maximum_discount"
                                    name="maximum_discount"
                                    class="form-control @error('maximum_discount') is-invalid @enderror"
                                    value="{{ old('maximum_discount') }}" placeholder="Leave empty for unlimited">

                                @error('maximum_discount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">
                                    Only applicable for Percentage coupons.
                                </small>
                            </div>

                            {{-- Usage Limit --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usage Limit</label>
                                <input type="number" min="1" name="usage_limit"
                                    class="form-control @error('usage_limit') is-invalid @enderror"
                                    value="{{ old('usage_limit') }}" placeholder="Leave empty for unlimited">

                                @error('usage_limit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Start Date --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Starts At <span class="text-danger">*</span></label>
                                <input type="date" name="starts_at" class="form-control @error('starts_at') is-invalid @enderror"
                                    value="{{ old('starts_at') }}">
                                @error('starts_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Expiry Date --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expires At <span class="text-danger">*</span></label>
                                <input type="date" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
                                    value="{{ old('expires_at') }}">

                                @error('expires_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>

                                <textarea name="description" id="description" rows="5"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Coupon description...">{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4">
                {{-- Publish Card --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Publish
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" id="status" name="status"
                                value="1" {{ old('status',1) ? 'checked' : '' }}>

                            <label class="form-check-label" for="status">
                                Active Coupon
                            </label>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save Coupon
                            </button>

                            <button type="reset" class="btn btn-label-secondary">
                                <i class="ti ti-refresh me-1"></i>
                                Reset
                            </button>

                            <a href="{{ route('coupons.index') }}" class="btn btn-label-danger">
                                <i class="ti ti-x me-1"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Coupon Information --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="ti ti-check text-success me-2"></i>
                                Coupon codes are automatically converted to uppercase.
                            </li>

                            <li class="mb-3">
                                <i class="ti ti-check text-success me-2"></i>
                                Fixed coupons deduct a fixed amount.
                            </li>

                            <li class="mb-3">
                                <i class="ti ti-check text-success me-2"></i>
                                Percentage coupons can use Maximum Discount.
                            </li>

                            <li class="mb-3">
                                <i class="ti ti-check text-success me-2"></i>
                                Leave Usage Limit empty for unlimited usage.
                            </li>

                            <li>
                                <i class="ti ti-check text-success me-2"></i>
                                Coupon expires automatically after the expiry date.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    @include('admin.coupons.partials.create-script')
@endpush
