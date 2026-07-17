@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{------------- Page Header -------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-users ti-md me-2 text-primary"></i>
                Booking Travelers Management
            </h4>
            <p class="text-muted mb-0">
                Manage all booking travelers.
            </p>
        </div>

        <div>
            @can('booking-travelers-create')
                <a href="{{ route('booking_travelers.create') }}"
                    class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    Add Traveler
                </a>
            @endcan
        </div>
    </div>

    {{------------- Dashboard Cards -------------}}
    <div class="row">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="fw-medium d-block mb-1">
                                Total
                            </span>
                            <h3 class="card-title mb-2">
                                {{ $cards['total'] }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="ti ti-users ti-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="fw-medium d-block mb-1">
                                Today
                            </span>
                            <h3 class="card-title mb-2">
                                {{ $cards['today'] }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="ti ti-calendar ti-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="fw-medium d-block mb-1">
                                Male
                            </span>
                            <h3 class="card-title mb-2">
                                {{ $cards['male'] }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="ti ti-user ti-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="fw-medium d-block mb-1">
                                Female
                            </span>
                            <h3 class="card-title mb-2">
                                {{ $cards['female'] }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded">
                                <i class="ti ti-user-x ti-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="fw-medium d-block mb-1">
                                Active
                            </span>
                            <h3 class="card-title mb-2">
                                {{ $cards['active'] }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="ti ti-circle-check ti-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="fw-medium d-block mb-1">
                                Inactive
                            </span>
                            <h3 class="card-title mb-2">
                                {{ $cards['inactive'] }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <div class="avatar-initial bg-label-secondary rounded">
                                <i class="ti ti-user-off ti-md"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{------------- Filters -------------}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                Filters
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Part 1B --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Booking</label>
                    <select id="booking_filter" class="form-select select2">
                        <option value="">All Bookings</option>
                        @foreach($bookings as $booking)
                            <option value="{{ $booking->id }}">
                                {{ $booking->booking_no }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Gender</label>
                    <select id="gender_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Nationality</label>
                    <input type="text" id="nationality_filter" class="form-control"placeholder="Nationality">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-md-9">
                    <input type="text" id="search" class="form-control"placeholder="Search traveler, passport, phone, email...">
                </div>

                <div class="col-md-3 text-end">
                    <button type="button" id="btnFilter" class="btn btn-primary">
                        <i class="ti ti-search me-1"></i>
                        Search
                    </button>

                    <button type="button" id="btnReset" class="btn btn-outline-secondary">
                        <i class="ti ti-refresh"></i>
                    </button>
                    <button type="button" id="btnReset" class="btn btn-outline-danger d-none">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{------------- DataTable -------------}}
    <div class="card">
        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="container-fluid">
                    <table class="travelerTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="travelerTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th width="60">#</th>
                                <th>Traveler</th>
                                <th width="130">Booking No</th>
                                <th>Customer</th>
                                <th>Tour</th>
                                <th width="90">Gender</th>
                                <th width="130">Nationality</th>
                                <th width="150">Passport</th>
                                <th width="140">Phone</th>
                                <th width="90">Status</th>
                                <th width="130">Created</th>
                                <th width="100">Action</th>
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
    @include('admin.booking_travelers.scripts')
@endpush
