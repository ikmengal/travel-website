@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- Header --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="ti ti-message-2 fs-1 text-primary me-2"></i>
                        Testimonials
                    </h4>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Testimonials
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" id="refreshTable">
                        <i class="ti ti-refresh me-1"></i>
                        Refresh
                    </button>
                    @can('testimonials-create')
                        <a href="{{ route('testimonials.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i>
                            Add Testimonial
                        </a>
                    @endcan
                    @can('testimonials-delete')
                        <button class="btn btn-danger d-none" id="bulkDelete">
                            <i class="ti ti-trash me-1"></i>
                            Bulk Delete
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- Dashboard Cards --}}
    <div class="row mb-3">
        {{-- Total --}}
        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-primary rounded-circle">
                                <i class="ti ti-message-2 fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Total
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['total'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Published --}}
        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-success rounded-circle">
                                <i class="ti ti-circle-check fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Published
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['published'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Draft --}}
        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-warning rounded-circle">
                                <i class="ti ti-edit fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Draft
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['draft'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Featured --}}
        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-info rounded-circle">
                                <i class="ti ti-star fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Featured
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['featured'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5 Stars --}}
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-warning rounded-circle">
                                <i class="ti ti-stars fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                5 Stars
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['five_star'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today --}}
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-danger rounded-circle">
                                <i class="ti ti-calendar fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Today
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['today'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- Filters --}}
    {{-- =============================================== --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                <i class="ti ti-filter me-2"></i>
                Filters
            </h5>
        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-lg-2 col-md-4">
                    <label class="form-label">
                        Status
                    </label>

                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Published</option>
                        <option value="0">Draft</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-4">
                    <label class="form-label">
                        Featured
                    </label>

                    <select id="featured_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Featured</option>
                        <option value="0">Normal</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-4">
                    <label class="form-label">
                        Rating
                    </label>

                    <select id="rating_filter" class="form-select select2">
                        <option value="">All Ratings</option>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-4">
                    <label class="form-label">
                        Date From
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        id="date_from">
                </div>

                <div class="col-lg-2 col-md-4">
                    <label class="form-label">
                        Date To
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        id="date_to">
                </div>

                <div class="col-lg-2 col-md-4 d-flex align-items-end">

                    <button class="btn btn-outline-secondary w-100" id="resetFilter">
                        <i class="ti ti-refresh me-1"></i>
                        Reset
                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- =============================================== --}}
    {{-- DataTable --}}
    {{-- =============================================== --}}
    <div class="card">
        <div class="card-body table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="datatable table border-top datatable no-footer dtr-column data_table table-responsive"
                    id="testimonialsDatatable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                    <thead>
                        <tr>
                            <th width="5%">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                            </th>
                            <th width="5%">#</th>
                            <th width="35%">Customer</th>
                            <th>Company</th>
                            <th width="10%">Rating</th>
                            <th width="5%">Featured</th>
                            <th width="5%">Status</th>
                            <th width="5%">Order</th>
                            <th width="20%">Created</th>
                            <th width="20%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.testimonials.partials.script')
@endpush
