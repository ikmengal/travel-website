@extends('admin.layouts.app')

@section('title', $title)

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- ========================================= --}}
    {{-- Page Header --}}
    {{-- ========================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="ti ti-ticket me-2 text-primary"></i>

                Coupon Details

            </h4>

            <p class="text-muted mb-0">

                View coupon information.

            </p>

        </div>

        <div>

            @can('coupons-edit')
            <a href="{{ route('coupons.edit', $coupon->id) }}"
               class="btn btn-warning">
                <i class="ti ti-edit me-1"></i>
                Edit
            </a>
            @endcan

            <a href="{{ route('coupons.index') }}"
               class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>

        </div>

    </div>

    <div class="row">

        {{-- ========================================= --}}
        {{-- Left Side --}}
        {{-- ========================================= --}}

        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Coupon Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tbody>

                        <tr>
                            <th width="30%">Coupon Code</th>
                            <td>{{ $coupon->code }}</td>
                        </tr>

                        <tr>
                            <th>Title</th>
                            <td>{{ $coupon->title }}</td>
                        </tr>

                        <tr>
                            <th>Discount Type</th>
                            <td>{!! couponTypeBadge($coupon->type) !!}</td>
                        </tr>

                        <tr>
                            <th>Discount Value</th>
                            <td>
                                @if($coupon->type == 'percentage')
                                    {{ $coupon->value }} %
                                @else
                                    {{ number_format($coupon->value,2) }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Minimum Amount</th>
                            <td>
                                {{ number_format($coupon->minimum_amount,2) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Maximum Discount</th>
                            <td>

                                @if($coupon->maximum_discount)

                                    {{ number_format($coupon->maximum_discount,2) }}

                                @else

                                    -

                                @endif

                            </td>
                        </tr>

                        <tr>

                            <th>Description</th>

                            <td>

                                {!! $coupon->description ?: '-' !!}

                            </td>

                        </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- ========================================= --}}
        {{-- Right Side --}}
        {{-- ========================================= --}}

        <div class="col-lg-4">

            {{-- Status --}}

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Status

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>

                            <th>Status</th>

                            <td>

                                {!! statusBadge($coupon->status) !!}

                            </td>

                        </tr>

                        <tr>

                            <th>Starts At</th>

                            <td>

                                {{ optional($coupon->starts_at)->format('d M Y') }}

                            </td>

                        </tr>

                        <tr>

                            <th>Expires At</th>

                            <td>

                                {{ optional($coupon->expires_at)->format('d M Y') }}

                            </td>

                        </tr>

                        <tr>

                            <th>Usage Limit</th>

                            <td>

                                {{ $coupon->usage_limit ?? 'Unlimited' }}

                            </td>

                        </tr>

                        <tr>

                            <th>Used</th>

                            <td>

                                {{ $coupon->used }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            {{-- Audit Information --}}

            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">

                        Audit Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>

                            <th width="45%">

                                ID

                            </th>

                            <td>

                                {{ $coupon->id }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Created At

                            </th>

                            <td>

                                {{ $coupon->created_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Updated At

                            </th>

                            <td>

                                {{ $coupon->updated_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
