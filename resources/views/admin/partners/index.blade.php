@extends('admin.layouts.app')
@section('title', 'Partners')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Partners Management
            </h4>
            <p class="text-muted mb-0">
                Manage website partners and brands.
            </p>
        </div>
        @can('partners-create')
            <a href="{{ route('partners.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add Partner
            </a>
        @endcan
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                Filters
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <label class="form-label">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search partner...">
                </div>

                <div class="col-lg-3 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-lg-3 mb-3">
                    <label class="form-label">Featured</label>
                    <select id="featured_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Featured</option>
                        <option value="0">Normal</option>
                    </select>
                </div>

                <div class="col-lg-2 d-flex align-items-end mb-3">
                    <button id="resetFilters" class="btn btn-label-secondary w-100">
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
            @can('partners-delete')
                <button id="bulkDeleteBtn" class="btn btn-danger mb-3 d-none">
                    <i class="ti ti-trash me-1"></i>
                    Delete Selected
                </button>
            @endcan
            <div class="table-responsive">
                <table id="partnersTable" class="table table table-hover">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="checkAll" class="form-check-input">
                            </th>
                            <th width="70">#</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Website</th>
                            <th>Sort Order</th>
                            <th>Featured</th>
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
    @include('admin.partners.partials.scripts')
@endpush
