@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- Page Header --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                {{-- Left Side --}}
                <div>
                    <h4 class="mb-1 fw-bold d-flex align-items-center">
                        <i class="ti ti-message-2 text-primary me-2"></i>
                        Contact Messages
                    </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Contact Messages
                            </li>
                        </ol>
                    </nav>
                </div>

                {{-- Right Side --}}
                <div class="d-flex align-items-center gap-2">
                    <button type="button" id="refreshTable" class="btn btn-outline-primary">
                        <i class="ti ti-refresh me-1"></i>
                        Refresh
                    </button>

                    @can('contacts-delete')
                        <button type="button" id="bulkDelete" class="btn btn-danger d-none">
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
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-primary rounded-circle">
                                <i class="ti ti-mail fs-4 mt-1"></i>
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

        {{-- Unread --}}
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-warning rounded-circle">
                                <i class="ti ti-mail-opened fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Unread
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['unread'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Read --}}
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-success rounded-circle">
                                <i class="ti ti-eye fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Read
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['read'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Replied --}}
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-info rounded-circle">
                                <i class="ti ti-arrow-back-up fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Replied
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['replied'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active --}}
        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md badge bg-label-success rounded-circle">
                                <i class="ti ti-shield-check fs-4 mt-1"></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small class="emp_post text-truncate text-muted">
                                Active
                            </small>
                            <a href="javascrip:;" class="text-body text-truncate">
                                <span class="fw-semibold">{{ $cards['active'] }}</span>
                            </a>
                        </div>
                        <div>
                            <i class="ti ti-circle text-success opacity-50"></i>
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
                                <i class="ti ti-calendar-event fs-4 mt-1"></i>
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

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="new">New</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">Read Status</label>
                    <select id="read_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Read</option>
                        <option value="0">Unread</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">Reply Status</label>
                    <select id="reply_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Replied</option>
                        <option value="0">Pending</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">Date From</label>
                    <input type="date" id="date_from" class="form-control">
                </div>

                <div class="col-lg-2 col-md-2 mb-3">
                    <label class="form-label">Date To</label>
                    <input type="date" id="date_to" class="form-control">
                </div>

                <div class="col-lg-2">
                    <label class="form-label">
                        &nbsp;
                    </label>
                    <button id="resetFilter" class="btn btn-outline-secondary w-100">
                        <i class="ti ti-refresh"></i>  &nbsp; Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card">
        <div class="card-body table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="couponTable table border-top datatable no-footer dtr-column data_table table-responsive"
                    id="datatable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="checkAll" class="form-check-input">
                            </th>
                            <th>#</th>
                            <th width="200">User</th>
                            <th width="160">Name</th>
                            <th width="120">Email</th>
                            <th width="220">Subject</th>
                            <th width="100">Read</th>
                            <th width="100">Replied</th>
                            <th width="100">Status</th>
                            <th width="180">Received</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.contact_messages.partials.reply_modal')
@endsection
@push('js')
    @include('admin.contact_messages.partials.scripts')
@endpush
