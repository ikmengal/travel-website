@extends('admin.layouts.app')
@section('title', 'Flight Class Details')
@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Flight Class Details
            </h4>

            <p class="text-muted mb-0">
                View complete flight class information.
            </p>

        </div>

        <div>

            @can('flight-classes-edit')
            <a href="{{ route('flight_classes.edit',$flightClass->id) }}"
                class="btn btn-primary">

                <i class="ti ti-edit me-1"></i>

                Edit

            </a>
            @endcan

            <a href="{{ route('flight_classes.index') }}"
                class="btn btn-label-secondary">

                <i class="ti ti-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <div class="row">

        {{-- Left --}}
        <div class="col-lg-8">

            {{-- Basic Information --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">
                        Basic Information
                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>
                            <th width="180">Name</th>
                            <td>{{ $flightClass->name }}</td>
                        </tr>

                        <tr>
                            <th>Slug</th>
                            <td>{{ $flightClass->slug }}</td>
                        </tr>

                        <tr>
                            <th>Baggage Allowance</th>
                            <td>

                                <span class="badge bg-label-primary fs-6">

                                    {{ $flightClass->baggage }} KG

                                </span>

                            </td>
                        </tr>

                        <tr>
                            <th>Seat Priority</th>
                            <td>

                                <span class="badge bg-label-info fs-6">

                                    {{ $flightClass->seat_priority }}

                                </span>

                            </td>
                        </tr>

                        <tr>

                            <th>Meal Included</th>

                            <td>

                                @if($flightClass->meal)

                                    <span class="badge bg-success">

                                        <i class="ti ti-check me-1"></i>

                                        Yes

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        <i class="ti ti-x me-1"></i>

                                        No

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>Refundable</th>

                            <td>

                                @if($flightClass->refundable)

                                    <span class="badge bg-success">

                                        <i class="ti ti-check me-1"></i>

                                        Yes

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        <i class="ti ti-x me-1"></i>

                                        No

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>Status</th>

                            <td>

                                @if($flightClass->status)

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>Sort Order</th>

                            <td>

                                {{ $flightClass->sort_order }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            {{-- Description --}}
            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">

                        Description

                    </h5>

                </div>

                <div class="card-body">

                    @if($flightClass->description)

                        {!! $flightClass->description !!}

                    @else

                        <div class="text-center py-5">

                            <i class="ti ti-file-text fs-1 text-muted"></i>

                            <h6 class="mt-3">

                                No Description Available

                            </h6>

                        </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- Right --}}
        <div class="col-lg-4">

            {{-- Flight Features --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Flight Features

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-grid gap-3">

                        <div class="border rounded-3 p-3">

                            <div class="d-flex justify-content-between">

                                <span>

                                    Baggage

                                </span>

                                <strong>

                                    {{ $flightClass->baggage }} KG

                                </strong>

                            </div>

                        </div>

                        <div class="border rounded-3 p-3">

                            <div class="d-flex justify-content-between">

                                <span>

                                    Seat Priority

                                </span>

                                <strong>

                                    {{ $flightClass->seat_priority }}

                                </strong>

                            </div>

                        </div>

                        <div class="border rounded-3 p-3">

                            <div class="d-flex justify-content-between">

                                <span>

                                    Meal

                                </span>

                                <strong>

                                    {!! $flightClass->meal
                                        ? '<span class="text-success">Available</span>'
                                        : '<span class="text-danger">Not Available</span>' !!}

                                </strong>

                            </div>

                        </div>

                        <div class="border rounded-3 p-3">

                            <div class="d-flex justify-content-between">

                                <span>

                                    Refundable

                                </span>

                                <strong>

                                    {!! $flightClass->refundable
                                        ? '<span class="text-success">Yes</span>'
                                        : '<span class="text-danger">No</span>' !!}

                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Information --}}
            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">

                        Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="120">

                                Created

                            </th>

                            <td>

                                {{ $flightClass->created_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Updated

                            </th>

                            <td>

                                {{ $flightClass->updated_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
