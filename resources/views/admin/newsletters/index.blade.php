@extends('admin.layouts.app')
@section('title', 'Newsletter Subscribers')
@section('content')
    <div class="card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h4 class="mb-1">
                    <i class="ti ti-news text-primary me-2"></i>
                    Newsletter Subscribers
                </h4>
                <small class="text-muted">Manage newsletter subscribers.</small>
            </div>
            <div class="mt-3 mt-md-0">
                @can('newsletters-create')
                    <a href="{{ route('newsletter_subscribers.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>
                        Add Subscriber
                    </a>
                @endcan
            </div>
        </div>

        <div class="card-body">
            {{-- Filters --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Subscribed</option>
                        <option value="0">Unsubscribed</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Verified</label>
                    <select id="verified_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Verified</option>
                        <option value="0">Pending</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Subscribed Date</label>
                    <input type="date" id="subscribed_date_filter" class="form-control">
                </div>

                <div class="col-12 text-end">
                    <button type="button" id="refreshFilters" class="btn btn-outline-secondary me-2">
                        <i class="ti ti-refresh me-1"></i>
                        Refresh
                    </button>
                    @can('newsletters-delete')
                        <button type="button" id="bulkDelete" class="btn btn-danger d-none">
                            <i class="ti ti-trash me-1"></i>
                            Bulk Delete
                        </button>
                    @endcan
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <table class="couponTable table border-top datatable no-footer dtr-column data_table table-responsive"
                        id="couponTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Verified At</th>
                                <th>Subscribed At</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
@endsection
@push('js')
    @include('admin.newsletters.partials.scripts')
@endpush
