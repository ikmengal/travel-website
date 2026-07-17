@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-credit-card ti-md me-2 text-primary"></i>
                Payment Management
            </h4>

            <p class="text-muted mb-0">
                Manage all booking payments from one place.
            </p>
        </div>

        @can('payments-create')
            <a href="{{ route('payments.create') }}"
                class="btn btn-primary">
                <i class="ti ti-plus"></i>
                Add Payment
            </a>
        @endcan
    </div>

    {{-- Dashboard Cards --}}
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <small class="text-muted">
                        Total Payments
                    </small>
                    <h4 class="mb-0">
                        {{ $cards['total'] }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <small class="text-muted">
                        Today's Payments
                    </small>
                    <h4 class="mb-0">
                        {{ $cards['today'] }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <small class="text-muted">
                        Pending
                    </small>
                    <h4 class="mb-0">
                        {{ $cards['pending'] }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <small class="text-muted">
                        Paid
                    </small>
                    <h4 class="mb-0">
                        {{ $cards['paid'] }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-start border-danger border-4">
                <div class="card-body">
                    <small class="text-muted">
                        Refunded
                    </small>
                    <h4 class="mb-0">
                        {{ $cards['refunded'] }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-start border-info border-4">
                <div class="card-body">
                    <small class="text-muted">
                        Revenue
                    </small>
                    <h4 class="mb-0">
                        {{ number_format($cards['revenue'],2) }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                Filters
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Booking</label>
                    <select class="form-select select2" id="booking_filter">
                        <option value="">All Bookings</option>
                        @foreach($bookings as $booking)
                            <option value="{{ $booking->id }}">
                                {{ $booking->booking_no }}
                                -
                                {{ $booking->user->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">Payment Method</label>
                    <select class="form-select select2" id="method_filter">
                        <option value="">All</option>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                        <option value="jazzcash">JazzCash</option>
                        <option value="easypaisa">EasyPaisa</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">Payment Status</label>
                    <select class="form-select select2" id="status_filter">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                        <option value="refunded">Refunded</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">Payment Date</label>
                    <input type="date" id="payment_date" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Payment No / Customer / Transaction ID">
                </div>

                <div class="col-12">
                    <button type="button" id="btnFilter" class="btn btn-primary">
                        <i class="ti ti-filter me-1"></i>
                        Apply Filter
                    </button>
                    <button type="button" id="btnReset" class="btn btn-label-secondary">
                        <i class="ti ti-refresh me-1"></i>
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                Payments List
            </h5>
            <div>
                @can('payments-delete')
                    <button type="button" class="btn btn-danger d-none" id="bulkDelete">
                        <i class="ti ti-trash"></i>
                        Bulk Delete
                    </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class="paymentsTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                            id="paymentsTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="checkAll" class="form-check-input">
                                    </th>
                                    <th width="50">#</th>
                                    <th>Payment No</th>
                                    <th>Booking</th>
                                    <th>Customer</th>
                                    <th>Method</th>
                                    <th>Gateway</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Status</th>
                                    <th>Payment Date</th>
                                    <th>Created</th>
                                    <th width="140">Action</th>
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
    @include('admin.payments.partials.scripts')
@endpush
