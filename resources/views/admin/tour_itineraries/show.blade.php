@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Tour Itinerary Details
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('tour_itineraries.index') }}">
                            Tour Itineraries
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Details
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2">
            @can('tour-itineraries-edit')
                <a href="{{ route('tour_itineraries.edit',$itinerary->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan
            <a href="{{ route('tour_itineraries.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-------------  LEFT -------------}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Itinerary Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="220">Tour</th>
                            <td>
                                {{ $itinerary->tour->title ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Day</th>
                            <td>
                                <span class="badge bg-label-primary fs-6">
                                    Day {{ $itinerary->day }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td>
                                {{ $itinerary->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($itinerary->status)
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
                                {{ $itinerary->created_at->format('d M Y h:i A') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>
                                {{ $itinerary->updated_at->format('d M Y h:i A') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Description
                    </h5>
                </div>

                <div class="card-body">
                    {!! $itinerary->description !!}
                </div>
            </div>
        </div>

        {{------------- RIGHT -------------}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Quick Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Tour
                        </small>
                        <strong>
                            {{ $itinerary->tour->title ?? '-' }}
                        </strong>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Day Number
                        </small>
                        <span class="badge bg-label-primary">
                            Day {{ $itinerary->day }}
                        </span>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Status
                        </small>
                        @if($itinerary->status)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Inactive
                            </span>
                        @endif
                    </div>
                    <hr>
                    <div>
                        <small class="text-muted d-block">
                            Created
                        </small>
                        {{ $itinerary->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
