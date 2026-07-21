@extends('admin.layouts.app')

@section('title', 'Pages')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Pages CMS
            </h4>

            <p class="text-muted mb-0">
                Manage website pages.
            </p>

        </div>

        @can('pages-create')
            <a href="{{ route('pages.create') }}" class="btn btn-primary">

                <i class="ti ti-plus me-1"></i>

                Add Page

            </a>
        @endcan

    </div>

    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card">

                <div class="card-body">

                    <span class="text-muted">

                        Total Pages

                    </span>

                    <h3 class="mt-2">

                        {{ \App\Models\Page::count() }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card">

                <div class="card-body">

                    <span class="text-muted">

                        Active

                    </span>

                    <h3 class="text-success mt-2">

                        {{ \App\Models\Page::where('status',1)->count() }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card">

                <div class="card-body">

                    <span class="text-muted">

                        Featured

                    </span>

                    <h3 class="text-warning mt-2">

                        {{ \App\Models\Page::where('featured',1)->count() }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card">

                <div class="card-body">

                    <span class="text-muted">

                        Inactive

                    </span>

                    <h3 class="text-danger mt-2">

                        {{ \App\Models\Page::where('status',0)->count() }}

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

                    <label class="form-label">

                        Search

                    </label>

                    <input type="text"
                           id="search"
                           class="form-control"
                           placeholder="Search title or slug">

                </div>

                {{-- Page Type --}}
                <div class="col-lg-3 mb-3">

                    <label class="form-label">

                        Page Type

                    </label>

                    <select id="page_type_filter"
                            class="form-select select2">

                        <option value="">

                            All

                        </option>

                        @foreach(\App\Models\Page::PAGE_TYPES as $value => $label)

                            <option value="{{ $value }}">

                                {{ $label }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Status --}}
                <div class="col-lg-2 mb-3">

                    <label class="form-label">

                        Status

                    </label>

                    <select id="status_filter"
                            class="form-select select2">

                        <option value="">All</option>

                        <option value="1">Active</option>

                        <option value="0">Inactive</option>

                    </select>

                </div>

                {{-- Featured --}}
                <div class="col-lg-2 mb-3">

                    <label class="form-label">

                        Featured

                    </label>

                    <select id="featured_filter"
                            class="form-select select2">

                        <option value="">All</option>

                        <option value="1">Featured</option>

                        <option value="0">Normal</option>

                    </select>

                </div>

                                {{-- Date From --}}
                <div class="col-lg-2 mb-3">

                    <label class="form-label">

                        Date From

                    </label>

                    <input
                        type="date"
                        id="date_from"
                        class="form-control">

                </div>

                {{-- Date To --}}
                <div class="col-lg-2 mb-3">

                    <label class="form-label">

                        Date To

                    </label>

                    <input
                        type="date"
                        id="date_to"
                        class="form-control">

                </div>

                {{-- Buttons --}}
                <div class="col-lg-3 mb-3 d-flex align-items-end">

                    <button
                        type="button"
                        id="resetFilters"
                        class="btn btn-label-secondary me-2">

                        <i class="ti ti-refresh me-1"></i>

                        Reset

                    </button>

                    @can('pages-delete')

                        <button
                            type="button"
                            id="bulkDelete"
                            class="btn btn-danger d-none">

                            <i class="ti ti-trash me-1"></i>

                            Delete Selected

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

                <table
                    id="pagesDatatable"
                    class="table table-bordered table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="40">

                                <input
                                    type="checkbox"
                                    id="checkAll"
                                    class="form-check-input">

                            </th>

                            <th width="60">

                                #

                            </th>

                            <th width="90">

                                Image

                            </th>

                            <th>

                                Title

                            </th>

                            <th width="150">

                                Page Type

                            </th>

                            <th width="100">

                                Featured

                            </th>

                            <th width="100">

                                Status

                            </th>

                            <th width="110">

                                Sort Order

                            </th>

                            <th width="130">

                                Created

                            </th>

                            <th width="170">

                                Action

                            </th>

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
    @include('admin.pages.partials.scripts')
@endpush
