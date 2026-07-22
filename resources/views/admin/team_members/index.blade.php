@extends('admin.layouts.app')
@section('title','Team Members')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Team Members
            </h4>
            <p class="text-muted mb-0">
                Manage your company team.
            </p>
        </div>
        @can('team-members-create')
            <a href="{{ route('team_members.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add Team Member
            </a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label>Search</label>
                    <input id="search" type="text" class="form-control" placeholder="Name or Designation">
                </div>
                <div class="col-md-3">
                    <label>Status</label>
                    <select id="status_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Featured</label>
                    <select id="featured_filter" class="form-select select2">
                        <option value="">All</option>
                        <option value="1">Featured</option>
                        <option value="0">Normal</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-label-secondary w-100" id="resetFilters">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="mb-1">
                        <i class="ti ti-list-details text-primary me-2"></i>
                        Team Member List
                    </h5>
                    <small class="text-muted">
                        Manage all team members.
                    </small>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button type="button" id="refreshTable" class="btn btn-label-primary">
                        <i class="ti ti-refresh me-1"></i>
                        Refresh
                    </button>
                    <div class="mt-3">
                        @can('team-members-delete')
                            <button id="bulkDeleteBtn" class="btn btn-danger mb-3 d-none">
                                Delete Selected
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container-fluid">
                        <table id="teamTable" class="table border-top dataTable no-footer data_table table-responsive" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                            <thead>
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                    </th>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Social</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.team_members.partials.scripts')
@endpush
