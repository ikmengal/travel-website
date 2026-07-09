@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    {{-------------- HEADER --------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Tour Departures
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Tour Departures
                    </li>
                </ol>
            </nav>
        </div>

        @can('tour-departures-create')
            <a href="{{ route('tour_departures.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i>
                Add Departure
            </a>
        @endcan
    </div>

    {{-------------- CARDS --------------}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Total Departures
                            </span>
                            <h3 class="mt-2">
                                {{ $totalDepartures ?? 0 }}
                            </h3>
                        </div>

                        <div class="badge bg-label-primary p-3 rounded">
                            <i class="ti ti-plane-departure fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Upcoming
                            </span>
                            <h3 class="mt-2">
                                {{ $upcomingDepartures ?? 0 }}
                            </h3>
                        </div>

                        <div class="badge bg-label-success p-3 rounded">
                            <i class="ti ti-calendar-event fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Completed
                            </span>
                            <h3 class="mt-2">
                                {{ $completedDepartures ?? 0 }}
                            </h3>
                        </div>

                        <div class="badge bg-label-warning p-3 rounded">
                            <i class="ti ti-calendar-off fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Active
                            </span>
                            <h3 class="mt-2">
                                {{ $activeDepartures ?? 0 }}
                            </h3>
                        </div>

                        <div class="badge bg-label-info p-3 rounded">
                            <i class="ti ti-circle-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-------------- FILTER --------------}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                Filters
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Tour</label>
                    <select id="tour_filter" class="form-select select2">
                        <option value="">
                            All Tours
                        </option>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}">
                                {{ $tour->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Departure Date</label>
                    <input type="date" id="departure_filter" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search departure...">
                </div>
            </div>
        </div>
    </div>

    {{-------------- DATATABLE --------------}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    Tour Departure List
                </h5>

                <small class="text-muted">
                    Manage all tour departures
                </small>
            </div>

            <div class="d-flex gap-2">
                <button id="refreshTable" class="btn btn-outline-primary">
                    <i class="ti ti-refresh"></i>
                </button>

                @can('tour-departures-delete')
                    <button id="bulkDelete" class="btn btn-outline-danger d-none">
                        <i class="ti ti-trash"></i>
                        Delete Selected
                    </button>
                @endcan
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="container-fluid">
                    <table class="tourItineraryTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="tourDepartureTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th>Tour</th>
                                <th>Departure</th>
                                <th>Return</th>
                                <th>Price</th>
                                <th>Seats</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th width="140">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.tour-departures.scripts')
@endpush
