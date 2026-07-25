@extends('admin.layouts.app')
@section('title', 'Flight Classes')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Flight Classes
            </h4>

            <p class="text-muted mb-0">
                Manage all flight classes from one place.
            </p>
        </div>

        <div class="d-flex gap-2">

            @can('flight-classes-create')
            <a href="{{ route('flight_classes.create') }}"
               class="btn btn-primary">

                <i class="ti ti-plus me-1"></i>

                Add Flight Class

            </a>
            @endcan

        </div>

    </div>

    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Total Classes
                            </small>

                            <h3 class="mb-0">
                                {{ $totalFlightClasses }}
                            </h3>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-primary">

                                <i class="ti ti-plane fs-3"></i>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Active
                            </small>

                            <h3 class="mb-0">
                                {{ $activeFlightClasses }}
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

        <div class="col-xl-3 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Meal Available
                            </small>

                            <h3 class="mb-0">

                                {{ $mealFlightClasses }}

                            </h3>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-warning">

                                <i class="ti ti-chef-hat fs-3"></i>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Refundable
                            </small>

                            <h3 class="mb-0">

                                {{ $refundableFlightClasses }}

                            </h3>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-info">

                                <i class="ti ti-cash fs-3"></i>

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

                    <i class="ti ti-filter me-2"></i>

                    Filter Flight Classes

                </h5>

                <div>

                    @can('flight-classes-delete')
                    <button
                        type="button"
                        id="bulkDeleteBtn"
                        class="btn btn-danger btn-sm d-none">

                        <i class="ti ti-trash me-1"></i>

                        Delete Selected

                    </button>
                    @endcan

                    <button
                        type="button"
                        id="resetFilter"
                        class="btn btn-label-secondary btn-sm">

                        <i class="ti ti-refresh me-1"></i>

                        Reset

                    </button>

                </div>

            </div>

        </div>

        <div class="card-body">

            <div class="row">

                {{-- Search --}}
                <div class="col-lg-3 col-md-6 mb-3">

                    <label class="form-label">

                        Search

                    </label>

                    <input
                        type="text"
                        id="search"
                        class="form-control"
                        placeholder="Name, slug...">

                </div>

                {{-- Status --}}
                <div class="col-lg-3 col-md-6 mb-3">

                    <label class="form-label">

                        Status

                    </label>

                    <select
                        id="status_filter"
                        class="form-select select2">

                        <option value="">
                            All
                        </option>

                        <option value="1">
                            Active
                        </option>

                        <option value="0">
                            Inactive
                        </option>

                    </select>

                </div>

                {{-- Meal --}}
                <div class="col-lg-3 col-md-6 mb-3">

                    <label class="form-label">

                        Meal

                    </label>

                    <select
                        id="meal_filter"
                        class="form-select select2">

                        <option value="">
                            All
                        </option>

                        <option value="1">
                            Yes
                        </option>

                        <option value="0">
                            No
                        </option>

                    </select>

                </div>

                {{-- Refundable --}}
                <div class="col-lg-3 col-md-6 mb-3">

                    <label class="form-label">

                        Refundable

                    </label>

                    <select
                        id="refundable_filter"
                        class="form-select select2">

                        <option value="">
                            All
                        </option>

                        <option value="1">
                            Yes
                        </option>

                        <option value="0">
                            No
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

    {{-- DataTable --}}
    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="card-title mb-0">

                    Flight Classes List

                </h5>

                <span class="badge bg-label-primary">

                    {{ $totalFlightClasses }} Records

                </span>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table
                    id="flightClassTable"
                    class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="40">

                                <div class="form-check">

                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        id="checkAll">

                                </div>

                            </th>

                            <th width="60">
                                #
                            </th>

                            <th>
                                Flight Class
                            </th>

                            <th>
                                Baggage
                            </th>

                            <th>
                                Seat Priority
                            </th>

                            <th>
                                Meal
                            </th>

                            <th>
                                Refundable
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="140">
                                Action
                            </th>

                        </tr>

                    </thead>

                </table>

            </div>

        </div>

    </div>
@endsection
@push('js')
    @include('admin.flight_classes.partials.script');
@endpush
