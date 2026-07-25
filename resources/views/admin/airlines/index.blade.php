@extends('admin.layouts.app')
@section('title', 'Airlines')
@section('content')
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Airlines Management
            </h4>

            <p class="text-muted mb-0">
                Manage all airlines, logos, airline codes and availability.
            </p>
        </div>

        @can('airlines-create')
            <a href="{{ route('airlines.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add Airline
            </a>
        @endcan
    </div>

    {{-- Statistics --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">Total Airlines</span>
                            <h3 class="fw-bold mt-2 mb-0">
                                {{ $totalAirlines }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-plane fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">Active</span>
                            <h3 class="fw-bold text-success mt-2 mb-0">
                                {{ $activeAirlines }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-check fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <span class="text-muted">

                                Featured

                            </span>

                            <h3 class="fw-bold text-warning mt-2 mb-0">

                                {{ $featuredAirlines }}

                            </h3>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-warning">

                                <i class="ti ti-star-filled fs-3"></i>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <span class="text-muted">

                                Inactive

                            </span>

                            <h3 class="fw-bold text-danger mt-2 mb-0">

                                {{ $inactiveAirlines }}

                            </h3>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-danger">

                                <i class="ti ti-ban fs-3"></i>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Search Filters
                </h5>

                <button type="button" class="btn btn-sm btn-label-secondary" id="resetFilters">
                    <i class="ti ti-refresh me-1"></i>
                    Reset
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Search --}}
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Name, Airline Code, IATA, ICAO...">
                </div>

                {{-- Featured --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Featured </label>
                    <select id="featured_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Featured</option>
                        <option value="0">Normal</option>
                    </select>
                </div>

                {{-- Status --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                {{-- Bulk Delete --}}
                <div class="col-lg-2 col-md-6 mb-3 d-flex align-items-end">
                    @can('airlines-delete')
                        <button id="bulkDeleteBtn" class="btn btn-danger w-100 d-none">
                            <i class="ti ti-trash me-1"></i>
                            Delete
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Airlines List</h5>
                <span class="badge bg-label-primary">
                    Total : {{ $totalAirlines }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="airlinesTable" width="100%">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                            </th>
                            <th width="60">#</th>
                            <th width="80">Logo</th>
                            <th>Airline</th>
                            <th width="100">IATA</th>
                            <th width="100">ICAO</th>
                            <th width="120">Airline Code</th>
                            <th>Website</th>
                            <th width="90">Featured</th>
                            <th width="90">Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.airlines.partials.scripts')
@endpush
