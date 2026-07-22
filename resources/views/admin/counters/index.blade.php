@extends('admin.layouts.app')
@section('title', 'Counters')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Counters Management
            </h4>
            <p class="text-muted mb-0">
                Manage homepage counters.
            </p>
        </div>
        @can('counters-create')
            <a href="{{ route('counters.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add Counter
            </a>
        @endcan
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filters</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search title...">
                </div>

                <div class="col-lg-4 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-lg-3 d-flex align-items-end mb-3">
                    <button class="btn btn-label-secondary w-100" id="resetFilters">
                        <i class="ti ti-refresh me-1"></i>
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Listing --}}
    <div class="card">
        <div class="card-body">
            @can('counters-delete')
                <button id="bulkDeleteBtn" class="btn btn-danger mb-3 d-none">
                    <i class="ti ti-trash me-1"></i>
                    Delete Selected
                </button>
            @endcan

            <div class="table-responsive">
                <table id="counterTable" class="table table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                            </th>
                            <th width="60">#</th>
                            <th width="80">Icon</th>
                            <th>Title</th>
                            <th>Value</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.counters.partials.scripts')
@endpush
