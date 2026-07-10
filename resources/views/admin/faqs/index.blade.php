@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{------------ PAGE HEADER ------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-help ti-md text-primary"></i>
                FAQ Management
            </h4>
            <p class="text-muted mb-0 px-1">
                Manage FAQs for Tours, Hotels, Destinations, Cars, Flights and Packages.
            </p>
        </div>
        <div>
            @can('faqs-create')
                <a href="{{ route('faqs.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    Add New FAQ
                </a>
            @endcan
        </div>
    </div>

    {{------------ BREADCRUMB ------------}}
    <nav aria-label="breadcrumb" class="mb-4 mx-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item active">
                FAQ Management
            </li>
        </ol>
    </nav>

    {{------------ DASHBOARD CARDS ------------}}
    <div class="row mb-4">
        {{-- Total FAQs --}}
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Total FAQs
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $totalFaqs }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <div class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-help fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Featured --}}
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Featured FAQs
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $featuredFaqs }}
                            </h3>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-star fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active --}}
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Active FAQs
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $activeFaqs }}
                            </h3>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-circle-check fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ Types --}}
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                FAQ Types
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $faqTypes }}
                            </h3>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial rounded bg-label-info">
                                <i class="ti ti-category fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{------------ FILTERS START ------------}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="ti ti-filter me-2"></i>
                Filters
            </h5>

            <button type="button" id="refreshTable" class="btn btn-md btn-outline-primary">
                <i class="ti ti-refresh me-1"></i>
                Refresh
            </button>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- FAQ Type --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">FAQ Type</label>

                    <select id="faq_type_filter" class="form-select select2">
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

                {{-- Status --}}
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                {{-- Featured --}}
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label">Featured</label>
                    <select id="featured_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Featured</option>
                        <option value="0">Normal</option>
                    </select>
                </div>

                {{-- Search --}}
                <div class="col-lg-2 col-md-12 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Question...">
                </div>
            </div>
        </div>
    </div>

    {{------------ DATATABLE ------------}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                FAQ List
            </h5>
            <button id="bulkDelete" class="btn btn-danger d-none">
                <i class="ti ti-trash me-1"></i>
                Delete Selected
            </button>
        </div>

        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="container-fluid">
                    <table class="tourItineraryTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="faqTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th width="70">#</th>
                                <th width="120">Type</th>
                                <th width="220">Related Item</th>
                                <th>Question</th>
                                <th width="250">Answer</th>
                                <th width="90">Featured</th>
                                <th width="90">Status</th>
                                <th width="80">Sort</th>
                                <th width="130">Created</th>
                                <th width="90">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{------------ DELETE MODAL ------------}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Delete FAQ

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="text-center">

                        <div class="mb-3">

                            <i class="ti ti-alert-triangle text-danger"
                                style="font-size:70px;"></i>

                        </div>

                        <h5>

                            Are you sure?

                        </h5>

                        <p class="text-muted mb-0">

                            You want to delete this FAQ.<br>

                            This action cannot be undone.

                        </p>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <form
                        id="deleteForm"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger">

                            <i class="ti ti-trash me-1"></i>

                            Delete

                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.faqs.scripts')
@endpush
