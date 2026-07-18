@extends('admin.layouts.app')
@section('title', 'Blog Categories')
@section('content')
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Blogs /</span>
                Blog Categories
            </h4>
            <p class="mb-0 text-muted">
                Manage all blog categories from here.
            </p>
        </div>

        <div class="d-flex gap-2">
            @can('blog-category-delete')
                <button class="btn btn-danger d-none" id="bulkDelete">
                    <i class="ti ti-trash me-1"></i>
                    Bulk Delete
                </button>
            @endcan
            @can('blog-category-create')
                <a href="{{ route('blog_categories.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    Add Category
                </a>
            @endcan
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                Filters
            </h5>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-5 col-md-6">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" placeholder="Search Category...">
                </div>

                <div class="col-lg-3 col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select select2" id="status_filter">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-3 d-flex align-items-end">
                    <button class="btn btn-outline-secondary w-100" id="resetFilter">
                        <i class="ti ti-refresh me-1"></i>
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card">
        <div class="card-body table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="datatable table border-top datatable no-footer dtr-column data_table table-responsive"
                    id="blogCategoryDatatable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                    <thead>
                        <tr>
                            <th width="5%">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                            </th>
                            <th width="5%">#</th>
                            <th width="30%">Category</th>
                            <th>Description</th>
                            <th width="8%">Status</th>
                            <th width="8%">Order</th>
                            <th width="15%">Created</th>
                            <th width="12%" class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.blog_categories.partials.scripts')
@endpush
