@extends('admin.layouts.app')
@section('title', 'Gallery')
@section('content')
    <div class="card">
        {{-- Header --}}
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    Gallery Management
                </h4>
                <small class="text-muted">
                    Manage gallery images.
                </small>
            </div>

            <div>
                @can('gallery-delete')
                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger d-none">
                        <i class="ti ti-trash me-1"></i>
                        Delete Selected
                    </button>
                @endcan
                @can('gallery-create')
                    <a href="{{ route('gallery.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>
                        Add Gallery
                    </a>
                @endcan
            </div>
        </div>

        {{-- Filters --}}
        <div class="card-body border-bottom">
            <div class="row">
                {{-- Search --}}
                <div class="col-lg-3 mb-3">
                    <label class="form-label"> Search </label>
                    <input type="text" id="search" class="form-control" placeholder="Title / Caption">
                </div>

                {{-- Category --}}
                <div class="col-lg-3 mb-3">
                    <label class="form-label">Category</label>
                    <select id="category_filter" class="form-select select2">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
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

                {{-- Status --}}
                <div class="col-lg-2 mb-3">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                {{-- Reset --}}
                <div class="col-lg-2 mb-3 d-flex align-items-end">
                    <button id="resetFilters" class="btn btn-label-secondary w-100">
                        <i class="ti ti-refresh me-1"></i>
                        Reset
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card-datatable table-responsive">
            <table id="galleryTable" class="table table">
                <thead>
                    <tr>
                        <th width="30">
                            <input type="checkbox" class="form-check-input" id="checkAll">
                        </th>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Sort</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.gallery.partials.scripts')
@endpush
