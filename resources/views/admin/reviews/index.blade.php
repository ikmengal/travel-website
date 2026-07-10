@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- ================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-star-filled text-warning me-2"></i>
                Reviews Management
            </h4>
            <p class="text-muted mb-0">
                Manage Tour, Hotel, Destination, Flight & Car Reviews.
            </p>
        </div>

        <div class="mt-3 mt-md-0">
            @can('reviews-create')
                <a href="{{ route('reviews.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    Add Review
                </a>
            @endcan
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- BREADCRUMB --}}
    {{-- ================================================= --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                Reviews Management
            </li>
        </ol>
    </nav>

    {{-- ================================================= --}}
    {{-- DASHBOARD CARDS --}}
    {{-- ================================================= --}}
    <div class="row">
        {{-- Total Reviews --}}
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Total Reviews
                            </small>
                            <h3 class="fw-bold mt-2">
                                {{ $totalReviews }}
                            </h3>
                        </div>

                        <div>
                            <span class="badge bg-label-primary rounded">
                                <i class="ti ti-star fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Approved --}}
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Approved
                            </small>
                            <h3 class="fw-bold mt-2 text-success">
                                {{ $approvedReviews }}
                            </h3>
                        </div>

                        <div>
                            <span class="badge bg-label-success rounded">
                                <i class="ti ti-circle-check fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Pending
                            </small>
                            <h3 class="fw-bold mt-2 text-danger">
                                {{ $pendingReviews }}
                            </h3>
                        </div>

                        <div>
                            <span class="badge bg-label-danger rounded">
                                <i class="ti ti-clock-off fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Featured --}}
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Featured
                            </small>
                            <h3 class="fw-bold mt-2 text-warning">
                                {{ $featuredReviews }}
                            </h3>
                        </div>

                        <div>
                            <span class="badge bg-label-warning rounded">
                                <i class="ti ti-feather fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Verified --}}
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Verified
                            </small>
                            <h3 class="fw-bold mt-2 text-info">
                                {{ $verifiedReviews }}
                            </h3>
                        </div>

                        <div>
                            <span class="badge bg-label-info rounded">
                                <i class="ti ti-shield-check fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Average Rating --}}
        <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Avg. Rating
                            </small>
                            <h3 class="fw-bold mt-2 text-warning">
                                ⭐ {{ number_format($averageRating,1) }}
                            </h3>
                        </div>

                        <div>
                            <span class="badge bg-label-warning rounded">
                                <i class="ti ti-stars fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- FILTER CARD --}}
    {{-- ================================================= --}}
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ti ti-filter me-2"></i>
                    Filters
                </h5>

                <button type="button" id="resetFilters" class="btn btn-md btn-outline-secondary">
                    <i class="ti ti-refresh me-1"></i>
                    Reset
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Search --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Title / Review...">
                </div>

                {{-- Review Type --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Review Type</label>
                    <select id="review_type_filter" class="form-select select2">
                        <option value="">All Types</option>
                        <option value="App\Models\Tour">Tour</option>
                        <option value="App\Models\Hotel">Hotel</option>
                        <option value="App\Models\Destination">Destination</option>
                        <option value="App\Models\Car">Car</option>
                        <option value="App\Models\Flight">Flight</option>
                        {{-- <option value="App\Models\TourPackage">Tour Package</option> --}}
                    </select>
                </div>

                {{-- Related Item --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Related Item</label>
                    <select id="related_item_filter" class="form-select select2">
                        <option value="">All</option>
                    </select>
                </div>

                {{-- Rating --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Rating</label>
                    <select id="rating_filter" class="form-select select2">
                        <option value="">All Ratings</option>
                        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4">⭐⭐⭐⭐ (4)</option>
                        <option value="3">⭐⭐⭐ (3)</option>
                        <option value="2">⭐⭐ (2)</option>
                        <option value="1">⭐ (1)</option>
                    </select>
                </div>

                {{-- Status --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Approved</option>
                        <option value="0">Pending</option>
                    </select>
                </div>

                {{-- Verified --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Verified</label>
                    <select id="verified_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Verified</option>
                        <option value="0">Not Verified</option>
                    </select>
                </div>

                {{-- Featured --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Featured</label>
                    <select id="featured_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Featured</option>
                        <option value="0">Normal</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- DATATABLE --}}
    {{-- ================================================= --}}
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">
                    <i class="ti ti-list-details me-2"></i>
                    Reviews List
                </h5>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary" id="reloadTable">
                        <i class="ti ti-refresh me-1"></i>
                        Refresh
                    </button>

                    @can('reviews-delete')
                        <button type="button" id="bulkDeleteBtn" class="btn btn-outline-danger d-none">
                            <i class="ti ti-trash me-1"></i>
                            Delete Selected
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="container-fluid">
                    <table class="tourItineraryTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="reviewTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th width="60">#</th>
                                <th width="120">Type</th>
                                <th width="180">Related Item</th>
                                <th width="170">Customer</th>
                                <th width="90">Rating</th>
                                <th width="220">Title</th>
                                <th width="90">Verified</th>
                                <th width="90">Featured</th>
                                <th width="90">Status</th>
                                <th width="120">Created</th>
                                <th width="90">Action</th>
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
    @include('admin.reviews.scripts')
@endpush
