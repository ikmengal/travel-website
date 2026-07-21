@extends('admin.layouts.app')
@section('title', 'Banners')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Banners
            </h4>
            <p class="text-muted mb-0">
                Manage website banners and homepage sliders.
            </p>
        </div>
        @can('banners-create')
            <a href="{{ route('banners.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add Banner
            </a>
        @endcan
    </div>

    {{-- Statistics --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">
                        Total Banners
                    </span>
                    <h3 class="mb-0">
                        {{ $banners ?? 0 }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">
                        Active
                    </span>
                    <h3 class="text-success mb-0">
                        {{ $activeBanner ?? 0 }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">
                        Featured
                    </span>
                    <h3 class="text-warning mb-0">
                        {{ $featuredBanner ?? 0 }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">
                        Inactive
                    </span>
                    <h3 class="text-danger mb-0">
                        {{ $inactiveBanner ?? 0 }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                {{-- Search --}}
                <div class="col-lg-3 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search banner...">
                </div>

                {{-- Status --}}
                <div class="col-lg-2 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                {{-- Featured --}}
                <div class="col-lg-2 mb-3">
                    <label class="form-label">Featured</label>
                    <select id="featured_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Featured</option>
                        <option value="0">Normal</option>
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

                {{-- Buttons --}}
                <div class="col-lg-3 mb-3 d-flex align-items-end">
                    <button type="button" id="resetFilters" class="btn btn-label-secondary me-2">
                        <i class="ti ti-refresh me-1"></i>
                        Reset
                    </button>
                    @can('banners-delete')
                        <button type="button" id="bulkDelete" class="btn btn-danger d-none">
                            <i class="ti ti-trash me-1"></i>
                            Bulk Delete
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="bannersDatatable" class="table border-top table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="checkAll" class="form-check-input">
                            </th>
                            <th width="60">#</th>
                            <th width="90">Image</th>
                            <th width="400">Title</th>
                            <th width="110">Featured</th>
                            <th width="100">Status</th>
                            <th width="100">Sort Order</th>
                            <th width="140">Created</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.banners.partials.scripts')
@endpush
