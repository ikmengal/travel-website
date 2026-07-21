@extends('admin.layouts.app')
@section('title', 'Blog Tags')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Blog Tags
            </h4>
            <p class="text-muted mb-0">
                Manage all blog tags from one place.
            </p>
        </div>
        @can('blog-tags-create')
            <a href="{{ route('blog_tags.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New Tag
            </a>
        @endcan
    </div>

    {{-- Statistics --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Total Tags
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $blogTag ?? 0 }}
                            </h3>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-tags fs-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Active
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $activeBlogTag ?? 0 }}
                            </h3>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-check fs-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Inactive
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $inActiveBlogTag ?? 0 }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-ban fs-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Tagged Blogs
                            </span>
                            <h3 class="mt-2 mb-0">
                                {{ $blogTagCount ?? 0 }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="ti ti-article fs-2"></i>
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
                    Filters
                </h5>

                <button type="button" id="resetFilters" class="btn btn-label-secondary">
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
                    <input type="text" id="search" class="form-control" placeholder="Search by name or slug">
                </div>

                {{-- Status --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                {{-- Date From --}}
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label">Date From</label>
                    <input type="date" id="date_from" class="form-control">
                </div>

                {{-- Date To --}}
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label">Date To</label>
                    <input type="date" id="date_to" class="form-control">
                </div>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Blog Tags List
                </h5>
                @can('blog-tags-delete')
                    <button type="button" id="bulkDelete" class="btn btn-danger d-none">
                        <i class="ti ti-trash me-1"></i>
                        Delete Selected
                    </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="blogTagsDatatable" class="table border-top table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">
                                <input type="checkbox" id="checkAll" class="form-check-input">
                            </th>
                            <th width="5%">#</th>
                            <th width="35%">Tag</th>
                            <th width="10%" class="text-center">Blogs</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="20%">Created At</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.blog_tags.partials.scripts')
@endpush
