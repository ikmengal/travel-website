@extends('admin.layouts.app')
@section('title', 'Blog Comments')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Blog Comments
            </h4>
            <p class="text-muted mb-0">
                Manage and moderate blog comments.
            </p>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">Total Comments</span>
                            <h3 class="mt-2 mb-0">
                                {{ $totalBlogComment ?? 0 }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-message-circle fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">Approved</span>
                            <h3 class="mt-2 mb-0">
                                {{ $approvedBlogComment ?? 0 }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-circle-check fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">Pending</span>
                            <h3 class="mt-2 mb-0">
                                {{ $pendingBlogComment ?? 0 }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-clock-hour-4 fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">Replies</span>
                            <h3 class="mt-2 mb-0">
                                {{ $repliesBlogComment ?? 0 }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="ti ti-message-reply fs-3"></i>
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
                <div class="col-lg-3 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Name, Email, Comment">
                </div>

                {{-- Blog --}}
                <div class="col-lg-3 mb-3">
                    <label class="form-label">Blog</label>
                    <select id="blog_filter" class="form-select select2">
                        <option value="">All Blogs</option>
                        @foreach($blogs as $blog)
                            <option value="{{ $blog->id }}">
                                {{ $blog->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="col-lg-2 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Approved</option>
                        <option value="0">Pending</option>
                    </select>
                </div>

                {{-- Date From --}}
                <div class="col-lg-2 mb-3">
                    <label class="form-label">Date From</label>
                    <input type="date" id="date_from" class="form-control">
                </div>

                {{-- Date To --}}
                <div class="col-lg-2 mb-3">
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
                    Blog Comments List
                </h5>

                @can('blog-comments-delete')
                    <button type="button" id="bulkDelete" class="btn btn-danger d-none">
                        <i class="ti ti-trash me-1"></i>
                        Delete Selected
                    </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container-fluid">
                        <table class="datatable table border-top dataTable no-footer dtr-column data_table table-responsive"id="blogCommentsDatatable"
                            aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                            <thead>
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="checkAll" class="form-check-input">
                                    </th>
                                    <th width="60">#</th>
                                    <th>Blog</th>
                                    <th width="220">User</th>
                                    <th>Comment</th>
                                    <th width="100">Type</th>
                                    <th width="100">Status</th>
                                    <th width="170">Date</th>
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
    @include('admin.blog_comments.partials.scripts')
@endpush
