@extends('admin.layouts.app')
@section('title', $title)
@section('content')
{{------------- PAGE HEADER -------------}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-route-2 text-primary me-2"></i>
            Tours
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Tours
                </li>
            </ol>
        </nav>
    </div>
    @can('tours-create')
        <div class="d-flex gap-2">
            <a href="{{ route('tours.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add Tour
            </a>
        </div>
    @endcan
</div>

{{------------- STATISTICS -------------}}
<div class="row mb-4">
    {{-- Total Tours --}}
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            Total Tours
                        </span>
                        <h3 class="fw-bold mt-2 mb-0">
                            {{ $totalTours ?? 0 }}
                        </h3>
                        <small class="text-success">
                            <i class="ti ti-arrow-up-right"></i>
                            All Records
                        </small>
                    </div>
                    <div class="badge bg-label-primary p-2 rounded">
                        <span class="avatar-initial">
                            <i class="ti ti-route fs-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Featured --}}
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            Featured Tours
                        </span>
                        <h3 class="fw-bold mt-2 mb-0">
                            {{ $featuredTours ?? 0 }}
                        </h3>
                        <small class="text-warning">
                            <i class="ti ti-star-filled"></i>
                            Featured Packages
                        </small>
                    </div>

                    <div class="badge bg-label-warning p-2 rounded">
                        <span class="avatar-initial">
                            <i class="ti ti-star fs-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Popular --}}
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            Popular Tours
                        </span>
                        <h3 class="fw-bold mt-2 mb-0">
                            {{ $popularTours ?? 0 }}
                        </h3>
                        <small class="text-info">
                            <i class="ti ti-trending-up"></i>
                            Trending
                        </small>
                    </div>
                    <div class="badge bg-label-info p-2 rounded">
                        <span class="avatar-initial">
                            <i class="ti ti-flame fs-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Active --}}
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            Active Tours
                        </span>
                        <h3 class="fw-bold mt-2 mb-0">
                            {{ $activeTours ?? 0 }}
                        </h3>

                        <small class="text-success">
                            <i class="ti ti-circle-check"></i>
                            Live Tours
                        </small>
                    </div>
                    <div class="badge bg-label-success p-2 rounded">
                        <span class="avatar-initial">
                            <i class="ti ti-circle-check fs-1"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{------------- FILTERS -------------}}
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">
                    <i class="ti ti-filter me-2 text-primary"></i>
                    Filter Tours
                </h5>
                <small class="text-muted">
                    Search tours using destination, category, status and
                    featured options.
                </small>
            </div>
            <button
                id="resetFilters"
                class="btn btn-label-secondary">
                <i class="ti ti-refresh me-1"></i>
                Reset
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row g-3">
            {{-- Destination --}}
            <div class="col-lg-3 col-md-6">
                <label class="form-label">
                    Destination
                </label>
                <select id="destination_filter" class="form-select select2">
                    <option value="">
                        All Destinations
                    </option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}">
                            {{ $destination->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Category --}}
            <div class="col-lg-3 col-md-6">
                <label class="form-label">
                    Category
                </label>

                <select id="category_filter" class="form-select select2">
                    <option value="">
                        All Categories
                    </option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div class="col-lg-2 col-md-6">
                <label class="form-label">
                    Status
                </label>

                <select id="status_filter" class="form-select">
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

            {{-- Featured --}}
            <div class="col-lg-2 col-md-6">
                <label class="form-label">
                    Featured
                </label>

                <select id="featured_filter" class="form-select">
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

            {{-- Search --}}
            <div class="col-lg-2 col-md-12">
                <label class="form-label">
                    Search
                </label>
                <input type="text" id="search" class="form-control" placeholder="Search Tour...">
            </div>
        </div>
    </div>
</div>

{{------------- TOURS LIST -------------}}
<div class="card">
    <div class="card-header border-bottom">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="mb-1">
                    <i class="ti ti-list-details text-primary me-2"></i>
                    Tours List
                </h5>
                <small class="text-muted">
                    Manage all travel packages from one place.
                </small>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button type="button" id="refreshTable" class="btn btn-label-primary">
                    <i class="ti ti-refresh me-1"></i>
                    Refresh
                </button>

                @can('tours-delete')
                    <button id="bulkDelete" class="btn btn-label-danger d-none">
                        <i class="ti ti-trash me-1"></i>
                        Delete Selected
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="container-fluid">
                    <table id="tourTable" class="table border-top dataTable no-footer data_table table-responsive" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th width="90"> Image </th>
                                <th> Tour </th>
                                <th> Destination </th>
                                <th> Category </th>
                                <th> Price </th>
                                <th> Duration </th>
                                <th> Rating </th>
                                <th> Featured </th>
                                <th> Popular </th>
                                <th> Status </th>
                                <th> Created </th>
                                <th width="90"> Action </th>
                            </tr>
                        </thead>
                        <tbody id="body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    @include('admin.tours.scripts')
@endpush
