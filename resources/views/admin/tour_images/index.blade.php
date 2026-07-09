@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Tour Images
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Tour Images
                    </li>
                </ol>
            </nav>
        </div>

        @can('tour-images-create')
            <a href="{{ route('tour_images.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i>
                Add Tour Image
            </a>
        @endcan
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Total Images
                            </small>
                            <h3 class="mt-2">
                                {{ $totalImages ?? 0 }}
                            </h3>
                        </div>

                        <span class="badge bg-label-primary p-3 rounded">
                            <i class="ti ti-photo ti-lg"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Featured
                            </small>
                            <h3 class="mt-2">
                                {{ $featuredImages ?? 0 }}
                            </h3>
                        </div>
                        <span class="badge bg-label-warning p-3 rounded">
                            <i class="ti ti-star ti-lg"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Active
                            </small>
                            <h3 class="mt-2">
                                {{ $activeImages ?? 0 }}
                            </h3>
                        </div>
                        <span class="badge bg-label-success p-3 rounded">
                            <i class="ti ti-circle-check ti-lg"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Tours Covered
                            </small>
                            <h3 class="mt-2">
                                {{ $tourCovered ?? 0 }}
                            </h3>
                        </div>
                        <span class="badge bg-label-info p-3 rounded">
                            <i class="ti ti-map-pin ti-lg"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{---------------- FILTERS ----------------}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                Filters
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label class="form-label">
                        Tour
                    </label>
                    <select id="tour_filter" class="form-select select2">
                        <option value="">
                            All Tours
                        </option>

                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}">
                                {{ $tour->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label class="form-label">
                        Tour
                    </label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">
                            All Status
                        </option>
                        <option value="1">Active</option>
                        <option value="0">In Active</option>
                    </select>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label class="form-label">
                        Search
                    </label>
                    <input type="text" id="search" class="form-control" placeholder="Search image...">
                </div>
            </div>
        </div>
    </div>

    {{---------------- DATATABLE ----------------}}
    <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">
                Tour Images
            </h5>
            <small class="text-muted">
                Manage all uploaded tour gallery images.
            </small>
        </div>

        <div class="d-flex gap-2">
            <button id="refreshTable" class="btn btn-outline-primary">
                <i class="ti ti-refresh"></i>
            </button>

            @can('tour-images-delete')
                <button id="bulkDelete" class="btn btn-outline-danger d-none">
                    <i class="ti ti-trash"></i>
                    Delete Selected
                </button>
            @endcan
        </div>
    </div>

    <div class="card-datatable table-responsive">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
            <div class="container-fluid">
                <table id="tourImageTable" class="table border-top dataTable no-footer data_table table-responsive" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="checkAll" class="form-check-input">
                            </th>
                            <th>Preview</th>
                            <th>Tour</th>
                            <th>Title</th>
                            <th>Caption</th>
                            <th>Sort Order</th>
                            <th>Ststus</th>
                            <th>Created</th>
                            <th width="130">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
    </div>
@endsection
@push('js')
    @include('admin.tour_images.scripts')
@endpush
