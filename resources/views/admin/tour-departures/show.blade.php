@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Tour Departure Details
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('tour_departures.index') }}">
                            Tour Departures
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Details
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2">
            @can('tour-departures-edit')
                <a href="{{ route('tour_departures.edit',$tourDeparture->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan

            <a href="{{ route('tour_departures.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{------------ LEFT ------------}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Departure Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="220">Tour</th>
                            <td>
                                {{ $tourDeparture->tour->title }}
                            </td>
                        </tr>

                        <tr>
                            <th>Departure Date</th>
                            <td>
                                {{ $tourDeparture->departure_date->format('d M Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Return Date</th>
                            <td>
                                {{ $tourDeparture->return_date->format('d M Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Duration</th>
                            <td>
                                {{ $tourDeparture->departure_date->diffInDays($tourDeparture->return_date) }}
                                Days
                            </td>
                        </tr>

                        <tr>
                            <th>Price</th>
                            <td>
                                Rs.
                                {{ number_format($tourDeparture->price,2) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Available Seats</th>
                            <td>
                                <span class="badge bg-label-primary">
                                    {{ $tourDeparture->available_seats }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($tourDeparture->status)
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
                            <th>Created At</th>
                            <td>
                                {{ $tourDeparture->created_at->format('d M Y h:i A') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Updated At</th>
                            <td>
                                {{ $tourDeparture->updated_at->format('d M Y h:i A') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{------------ RIGHT ------------}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Departure Summary
                    </h5>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="ti ti-plane-departure text-primary" style="font-size:70px;"></i>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Tour
                        </small>
                        <strong>
                            {{ $tourDeparture->tour->title }}
                        </strong>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Departure
                        </small>
                        <strong>
                            {{ $tourDeparture->departure_date->format('d M Y') }}
                        </strong>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Return
                        </small>
                        <strong>
                            {{ $tourDeparture->return_date->format('d M Y') }}
                        </strong>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Price
                        </small>
                        <strong class="text-success">
                            Rs.
                            {{ number_format($tourDeparture->price,2) }}
                        </strong>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Seats Available
                        </small>
                        <span class="badge bg-label-info fs-6">
                            {{ $tourDeparture->available_seats }}
                        </span>
                    </div>

                    <hr>

                    <div>
                        <small class="text-muted d-block">
                            Created
                        </small>
                        {{ $tourDeparture->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
