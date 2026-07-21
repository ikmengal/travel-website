@extends('admin.layouts.app')
@section('title', 'Blogs')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Blogs Management
            </h4>
            <p class="text-muted mb-0">
                Manage all blog articles, featured posts and publishing status.
            </p>
        </div>
        @can('blogs-create')
            <a href="{{ route('blogs.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New Blog
            </a>
        @endcan
    </div>

    {{-- Statistics --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Total Blogs
                            </span>
                            <h3 class="fw-bold mt-2 mb-0" id="totalBlogs">
                                {{ $totalBlogs }}
                            </h3>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-article fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Published
                            </span>
                            <h3 class="fw-bold mt-2 mb-0" id="publishedBlogs">
                                {{ $publishedBlogs }}
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

        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Featured
                            </span>
                            <h3 class="fw-bold mt-2 mb-0" id="featuredBlogs">
                                {{ $featuredBlogs }}
                            </h3>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-diamond fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                Draft / Inactive
                            </span>
                            <h3 class="fw-bold mt-2 mb-0" id="draftBlogs">
                                {{ $inActiveBlogs }}
                            </h3>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="ti ti-file-off fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="ti ti-filter me-2"></i>
                Filter Blogs
            </h5>
            <button type="button" class="btn btn-sm btn-label-secondary" id="resetFilters">
                <i class="ti ti-refresh me-1"></i>
                Reset Filters
            </button>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Search --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Title, Slug or Author">
                </div>

                {{-- Category --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Category</label>
                    <select id="category_filter" class="form-select select2">
                        <option value="">All</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
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

                {{-- Date From --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Published From</label>
                    <input type="date" id="date_from" class="form-control">
                </div>

                {{-- Date To --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label">Published To</label>
                    <input type="date" id="date_to" class="form-control">
                </div>

                {{-- Apply Filter --}}
                <div class="col-lg-3 col-md-6 mb-3 d-flex align-items-end">
                    <button type="button" id="filterBtn" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i>
                        Apply Filters
                    </button>
                </div>

                {{-- Reset --}}
                <div class="col-lg-3 col-md-6 mb-3 d-flex align-items-end">
                    <button type="button" id="resetFiltersBottom" class="btn btn-label-secondary w-100">
                        <i class="ti ti-refresh me-1"></i>
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Blogs List --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h5 class="card-title mb-0">
                    <i class="ti ti-article me-2"></i>
                    Blogs List
                </h5>
                <small class="text-muted">
                    Manage all blogs from here.
                </small>
            </div>
            <div class="d-flex gap-2">
                @can('blogs-delete')
                    <button type="button" id="bulkDelete" class="btn btn-danger d-none">
                        <i class="ti ti-trash me-1"></i>
                        Delete Selected
                    </button>
                @endcan
            </div>
        </div>
        <div class="card-body p-0">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container-fluid">
                        <table class="datatable table border-top dataTable no-footer dtr-column data_table table-responsive"
                            id="blogsDatatable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                            <thead>
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="checkAll" class="form-check-input">
                                    </th>
                                    <th width="60">#</th>
                                    <th width="90">Image</th>
                                    <th>Blog</th>
                                    <th>Tags</th>
                                    <th width="180">Category</th>
                                    <th width="160">Author</th>
                                    <th width="90">Views</th>
                                    <th width="100" class="text-center">Featured</th>
                                    <th width="90" class="text-center">Status</th>
                                    <th width="150">Published</th>
                                    <th width="120" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.blogs.partials.scripts')
@endpush
