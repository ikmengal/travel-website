@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Destinations
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Destinations
                    </li>
                </ol>
            </nav>
        </div>
        <div>
            @can('destinations-create')
                <a href="{{ route('destinations.create') }}"
                    class="btn btn-primary">
                    <i class="ti ti-plus"></i>
                    Add Destination
                </a>
            @endcan
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Total Destinations
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $totalDestinations }}
                            </h3>
                        </div>
                        <div class="badge bg-label-primary p-2 rounded">
                            <i class="ti ti-map-pin ti-md"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Featured
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $featuredDestinations }}
                            </h3>
                        </div>
                        <div class="badge bg-label-success p-2 rounded">
                            <i class="ti ti-star ti-md"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Popular
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $popularDestinations }}
                            </h3>
                        </div>
                        <div class="badge bg-label-warning p-2 rounded">
                            <i class="ti ti-map-2 ti-md"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Active
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $activeDestinations }}
                            </h3>
                        </div>
                        <div class="badge bg-label-info p-2 rounded">
                            <i class="ti ti-circle-check ti-md"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                Filters
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">
                        Country
                    </label>
                    <select
                        id="country_filter"
                        class="form-select select2 select">
                        <option value="">
                            All Countries
                        </option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Status
                    </label>
                    <select
                        id="status_filter"
                        class="form-select">
                        <option value="">
                            All
                        </option>
                        <option value="1">
                            Active
                        </option>
                        <option value="0">
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Featured
                    </label>
                    <select
                        id="featured_filter"
                        class="form-select">
                        <option value="">
                            All
                        </option>
                        <option value="1">
                            Featured
                        </option>
                        <option value="0">
                            Normal
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Search
                    </label>
                    <input
                        type="text"
                        id="search"
                        class="form-control"
                        placeholder="Search Destination...">
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Destinations List</h5>
                <small class="text-muted">
                    Manage all travel destinations
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="button" id="refreshTable" class="btn btn-outline-primary">
                    <i class="ti ti-refresh"></i>
                </button>
                @can('destinations-delete')
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
                    <table id="destinationTable" class="table border-top dataTable no-footer data_table table-responsive" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="30">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th>Image</th>
                                <th>Destination</th>
                                <th>Country</th>
                                <th>Tours</th>
                                <th>Hotels</th>
                                <th>Featured</th>
                                <th>Popular</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.destinations.scripts')
@endpush
