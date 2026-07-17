@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{---------------- Page Header ----------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-ticket me-2 text-primary"></i>
                Coupons
            </h4>
            <p class="text-muted mb-0">
                Manage all discount coupons.
            </p>
        </div>

        <div>
            @can('coupons-create')
                <a href="{{ route('coupons.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    Add Coupon
                </a>
            @endcan
        </div>
    </div>

    {{---------------- Dashboard Cards ----------------}}
    <div class="row">
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold">
                        Total
                    </span>
                    <h3 class="mt-2">
                        {{ $cards['total'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold">
                        Active
                    </span>
                    <h3 class="mt-2 text-success">
                        {{ $cards['active'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold">
                        Expired
                    </span>
                    <h3 class="mt-2 text-danger">
                        {{ $cards['expired'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold">
                        Upcoming
                    </span>
                    <h3 class="mt-2 text-warning">
                        {{ $cards['upcoming'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold">
                        Used
                    </span>
                    <h3 class="mt-2 text-info">
                        {{ $cards['used'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold">
                        Redemptions
                    </span>
                    <h3 class="mt-2 text-primary">
                        {{ $cards['redemptions'] }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{---------------- Filters ----------------}}
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="ti ti-filter me-2"></i>
                Filters
            </h5>

            <div class="text-end mt-3">
                <button type="button" id="refreshFilters" class="btn btn-outline-primary me-2">
                    <i class="ti ti-refresh me-1"></i>
                    Refresh
                </button>

                @can('coupons-delete')
                    <button type="button" id="bulkDelete" class="btn btn-outline-danger d-none">
                        <i class="ti ti-trash me-1"></i>
                        Bulk Delete
                    </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Type</label>
                    <select id="type_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="fixed">Fixed</option>
                        <option value="percentage">Percentage</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Starts At</label>
                    <input type="date" id="starts_at_filter" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Expires At</label>
                    <input type="date" id="expires_at_filter" class="form-control">
                </div>
            </div>
        </div>
    </div>

    {{---------------- DataTable ----------------}}
    <div class="card mt-4">
        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="container-fluid">
                    <table class="couponTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="couponTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Min Amount</th>
                                <th>Max Discount</th>
                                <th>Usage Limit</th>
                                <th>Used</th>
                                <th>Starts</th>
                                <th>Expires</th>
                                <th>Status</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.coupons.partials.scripts')
@endpush
