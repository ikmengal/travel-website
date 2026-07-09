@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    {{------------ HEADER ------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Tour Excludes
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Tour Excludes
                    </li>
                </ol>
            </nav>
        </div>

        @can('tour-excludes-create')
            <a href="{{ route('tour_excludes.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i>
                Add Excludes
            </a>
        @endcan
    </div>

    {{------------ STATS ------------}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Total Excludes
                            </span>
                            <h3 class="mt-2">
                                {{ $totalExcludes ?? 0 }}
                            </h3>
                        </div>
                        <div class="badge bg-label-primary p-3 rounded">
                            <i class="ti ti-list-check ti-md"></i>
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
                                {{ $activeExcludes ?? 0 }}
                            </h3>
                        </div>
                        <div class="badge bg-label-success p-3 rounded">
                            <i class="ti ti-circle-check ti-md"></i>
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
                                Exclude
                            </span>
                            <h3 class="mt-2">
                                {{ $inactiveExcludes ?? 0 }}
                            </h3>
                        </div>
                        <div class="badge bg-label-danger p-3 rounded">
                            <i class="ti ti-ban ti-md"></i>
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
                                Tours
                            </span>
                            <h3 class="mt-2">
                                {{ $totalTours ?? 0 }}
                            </h3>
                        </div>
                        <div class="badge bg-label-info p-3 rounded">
                            <i class="ti ti-map-pin ti-md"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{------------ FILTER ------------}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                Filters
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
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

                <div class="col-md-4">
                    <label class="form-label"> Status </label>
                    <select id="status_filter" class="form-select select2">
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

                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search include...">
                </div>
            </div>
        </div>
    </div>

    {{------------ DATATABLE ------------}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    Tour Excludes
                </h5>
                <small class="text-muted">
                    Manage tour exclude items
                </small>
            </div>
            <div class="d-flex gap-2">
                <button type="button" id="refreshTable" class="btn btn-outline-primary">
                    <i class="ti ti-refresh"></i>
                </button>
                @can('tour-excludes-delete')
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
                    <table class="tourIncludeTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="tourExcludeTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th>Tour</th>
                                <th width="80">Icon</th>
                                <th>Title</th>
                                <th width="110">Sort Order</th>
                                <th width="100">Status</th>
                                <th width="150">Created</th>
                                <th width="120">Action</th>
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
    @include('admin.tour_excludes.scripts')
@endpush
