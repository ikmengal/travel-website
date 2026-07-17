@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-edit me-2 text-warning"></i>
                Edit Coupon
            </h4>
            <p class="text-muted mb-0">
                Update coupon information.
            </p>
        </div>

        <div>
            <a href="{{ route('coupons.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <form id="couponForm" action="{{ route('coupons.update',$coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Left Side --}}
            <div class="col-lg-8">
                <div class="card">
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
                                    <input type="text" id="code" name="code"
                                        class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code',$coupon->code) }}">

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
                                <input type="text"
                                    name="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title',$coupon->title) }}">

                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Discount Type --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Type</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="fixed"
                                        {{ old('type',$coupon->type)=='fixed' ? 'selected' : '' }}>
                                        Fixed Amount
                                    </option>

                                    <option value="percentage"
                                        {{ old('type',$coupon->type)=='percentage' ? 'selected' : '' }}>
                                        Percentage
                                    </option>
                                </select>
                            </div>

                            {{-- Discount Value --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Value</label>
                                <input type="number" step="0.01" min="0" name="value" class="form-control" value="{{ old('value',$coupon->value) }}">
                            </div>

                            {{-- Minimum Booking Amount --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Booking Amount</label>
                                <input type="number" step="0.01" min="0" name="minimum_amount"
                                    class="form-control @error('minimum_amount') is-invalid @enderror"
                                    value="{{ old('minimum_amount', $coupon->minimum_amount) }}">

                                @error('minimum_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Maximum Discount --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Maximum Discount</label>
                                <input type="number" step="0.01" min="0" id="maximum_discount" name="maximum_discount"
                                    class="form-control @error('maximum_discount') is-invalid @enderror"
                                    value="{{ old('maximum_discount', $coupon->maximum_discount) }}"
                                    placeholder="Leave empty for unlimited">

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
                                    value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                    placeholder="Leave empty for unlimited">

                                @error('usage_limit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Used Count (Read Only) --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Used Count</label>
                                <input type="number" class="form-control" value="{{ $coupon->used }}" readonly>
                                <small class="text-muted">
                                    This value is updated automatically after coupon usage.
                                </small>
                            </div>

                            {{-- Starts At --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Starts At <span class="text-danger">*</span></label>
                                <input type="date" name="starts_at" class="form-control @error('starts_at') is-invalid @enderror"
                                    value="{{ old('starts_at', $coupon->starts_at) }}">

                                @error('starts_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Expires At --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expires At <span class="text-danger">*</span></label>
                                <input type="date" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
                                    value="{{ old('expires_at', $coupon->expires_at) }}">

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
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $coupon->description) }}</textarea>
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
                            <input class="form-check-input" type="checkbox" id="status"
                                name="status" value="1" {{ old('status', $coupon->status) ? 'checked' : '' }}>

                            <label class="form-check-label" for="status">Active Coupon</label>
                        </div>
                        <hr>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Update Coupon
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
                            Coupon Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th width="45%">Coupon ID</th>
                                <td>#{{ $coupon->id }}</td>
                            </tr>

                            <tr>
                                <th>Created</th>
                                <td>{{ $coupon->created_at->format('d M Y') }}</td>
                            </tr>

                            <tr>
                                <th>Updated</th>
                                <td>{{ $coupon->updated_at->format('d M Y') }}</td>
                            </tr>

                            <tr>
                                <th>Used</th>
                                <td>{{ $coupon->used }} time(s)</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>{!! statusBadge($coupon->status) !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    @include('admin.coupons.partials.edit-script')
@endpush
