@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{--------------- Page Header ---------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-ticket ti-md me-2 text-primary"></i>
                Booking Management
            </h4>
            <p class="text-muted mb-0">
                Manage all tour bookings, travelers and payment statuses.
            </p>
        </div>

        <div>
            @can('bookings-create')
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    Add Booking
                </a>
            @endcan
        </div>
    </div>

    {{--------------- Dashboard Cards ---------------}}
    <div class="row mb-3">
        {{-- Total Bookings --}}
        <div class="col-xl-3 col-md-6 col-sm-6 mb-1">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Total Bookings
                            </span>
                            <h3 class="fw-bold mt-2 mb-0">
                                {{ $totalBookings }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-ticket fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today's Bookings --}}
        <div class="col-xl-3 col-md-6 col-sm-6 mb-1">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Today's Bookings
                            </span>
                            <h3 class="fw-bold mt-2 mb-0">
                                {{ $todayBookings }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="ti ti-calendar-event fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Bookings --}}
        <div class="col-xl-3 col-md-6 col-sm-6 mb-1">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Pending Bookings
                            </span>
                            <h3 class="fw-bold mt-2 mb-0 text-warning">
                                {{ $pendingBookings }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-clock-off fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Confirmed Bookings --}}
        <div class="col-xl-3 col-md-6 col-sm-6 mb-1">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Confirmed
                            </span>
                            <h3 class="fw-bold mt-2 mb-0 text-success">
                                {{ $confirmedBookings }}
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
    </div>

    <div class="row mb-3">
        {{-- Completed --}}
        <div class="col-xl-3 col-md-6 col-sm-6 mb-1">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Completed
                            </span>
                            <h3 class="fw-bold mt-2 mb-0 text-success">
                                {{ $completedBookings }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-checkup-list fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cancelled --}}
        <div class="col-xl-3 col-md-6 col-sm-6 mb-1">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Cancelled
                            </span>
                            <h3 class="fw-bold mt-2 mb-0 text-danger">
                                {{ $cancelledBookings }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="ti ti-circle-x fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Payments --}}
        <div class="col-xl-3 col-md-6 col-sm-6 mb-1">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Pending Payments
                            </span>
                            <h3 class="fw-bold mt-2 mb-0 text-warning">
                                {{ $pendingPayments }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-credit-card fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="col-xl-3 col-md-6 col-sm-6 mb-1">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Total Revenue
                            </span>
                            <h3 class="fw-bold mt-2 mb-0 text-primary">
                                {{ number_format($totalRevenue,2) }}
                            </h3>
                        </div>

                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-cash-banknote fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--------------- Filters ---------------}}
    <div class="card mb-4">
        <div class="card-header">
            <div class="row g-3">
                {{-- Search --}}
                <div class="col-lg-3">
                    <label class="form-label"> Search </label>
                    <input type="text" id="search" class="form-control" placeholder="Booking No / Customer">
                </div>

                {{-- Customer --}}
                <div class="col-lg-3">
                    <label class="form-label"> Customer </label>
                    <select id="customer_filter" class="form-select select2">
                        <option value=""> All Customers </option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tour --}}
                <div class="col-lg-3">
                    <label class="form-label"> Tour </label>
                    <select id="tour_filter" class="form-select select2">
                        <option value=""> All Tours </option>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}">
                                {{ $tour->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Departure --}}
                <div class="col-lg-3">
                    <label class="form-label"> Departure </label>
                    <select id="departure_filter" class="form-select select2">
                        <option value=""> All Departures </option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mt-1">
                {{-- Booking Status --}}
                <div class="col-lg-2">
                    <label class="form-label"> Booking Status </label>
                    <select id="booking_status_filter" class="form-select select2">
                        <option value=""> All Status </option>
                        <option value="pending"> Pending </option>
                        <option value="confirmed"> Confirmed </option>
                        <option value="completed"> Completed </option>
                        <option value="cancelled"> Cancelled </option>
                        <option value="refunded"> Refunded </option>
                    </select>
                </div>

                {{-- Payment Status --}}
                <div class="col-lg-2">
                    <label class="form-label"> Payment Status </label>
                    <select id="payment_status_filter" class="form-select select2">
                        <option value=""> All Payments </option>
                        <option value="pending"> Pending </option>
                        <option value="paid"> Paid </option>
                        <option value="failed"> Failed </option>
                        <option value="refunded"> Refunded </option>
                    </select>
                </div>

                {{-- Date From --}}
                <div class="col-lg-2">
                    <label class="form-label"> Date From</label>
                    <input type="date" id="date_from" class="form-control">
                </div>

                {{-- Date To --}}
                <div class="col-lg-2">
                    <label class="form-label"> Date To </label>
                    <input type="date" id="date_to" class="form-control">
                </div>

                {{-- Buttons --}}
                <div class="col-lg-4">
                    <label class="form-label d-block">&nbsp;</label>
                    <button class="btn btn-primary" id="filterBtn">
                        <i class="ti ti-search me-1"></i>
                        Filter
                    </button>

                    <button class="btn btn-outline-secondary" id="resetBtn">
                        <i class="ti ti-refresh me-1"></i>
                        Reset
                    </button>

                    @can('bookings-bulk-delete')
                        <button class="btn btn-danger d-none" id="bulkDeleteBtn">
                            <i class="ti ti-trash me-1"></i>
                            Delete Bulk
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{--------------- DataTable ---------------}}
    <div class="card">
        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="container-fluid">
                    <table class="bookingTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="bookingTable" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll" class="form-check-input">
                                </th>
                                <th width="60">#</th>
                                <th width="140">Booking #</th>
                                <th width="220">Customer</th>
                                <th width="220">Tour</th>
                                <th width="160">Departure</th>
                                <th width="130">Payment Status</th>
                                <th width="130">Booking Status</th>
                                <th width="120">Total Amount</th>
                                <th width="150">Created At</th>
                                <th width="100">Action</th>
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
    @include('admin.bookings.scripts')
@endpush
