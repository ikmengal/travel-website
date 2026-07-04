@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    <input type="hidden" id="page_url" value="{{ route('permissions.index') }}">
    <div class="card mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card-header">
                    <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Home /</span> {{ $title }}</h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dt-buttons btn-group flex-wrap float-end mt-4">
                    @can('permissions-create')
                        <button
                            id="add-btn"
                            data-toggle="tooltip" data-placement="top" title="Add Permission"
                            data-url="{{ route('permissions.store') }}"
                            class="btn add-new btn-primary mb-3 mb-md-0 mx-3"
                            tabindex="0" aria-controls="DataTables_Table_0"
                            type="button" data-bs-toggle="modal"
                            data-bs-target="#addPermissionModal">
                            <span>
                                <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                <span class="d-none d-sm-inline-block"> Add Permission </span>
                            </span>
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Permission List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container-fluid">
                        <table class="datatables-users table border-top dataTable no-footer dtr-column data_table table-responsive" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 1227px;">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Permission Url</th>
                                    <th scope="col" width="40%">Permissions</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Add Permission Modal -->
                <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <h3 class="mb-2" id="modal-label">Add New Permission</h3>
                                    <p class="text-muted">Permissions you may use and assign to your users.</p>
                                </div>
                                <form id="create-form" data-modal-id="addPermissionModal" class="row">
                                    @csrf
                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="name">Permission Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Hotels, Users" autofocus />
                                        <small class="text-muted">
                                            This will generate permissions like hotels-list, hotels-create...
                                        </small> <br>
                                        <span class="text-danger error" id="name_error"></span>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">
                                            Custom Permissions
                                            <small class="text-muted">(Optional)</small>
                                        </label>
                                        <input type="text" name="custom" class="form-control" placeholder="approve,reject,publish">
                                        <small class="text-muted">
                                            Separate multiple permissions with commas.
                                        </small><br>
                                        <span class="text-danger error" id="custom_error"></span>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <div class="card-body border-top p-9">
                                            <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Col-->
                                                        <div class="col-lg-8 fv-row">
                                                            <!-- Default checkbox -->
                                                            <div class="col-lg-4">
                                                                <span class="text-danger">*</span>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="all" id="checkAll"/>
                                                                    <label class="form-check-label" for="checkAll"> <strong> Select All</strong> </label>
                                                                </div>
                                                            </div>
                                                            <!-- Default checkbox -->
                                                            @php
                                                                $actions = [
                                                                    'list',
                                                                    'view',
                                                                    'create',
                                                                    'edit',
                                                                    'delete',
                                                                    'status',
                                                                    'restore',
                                                                    'force-delete',
                                                                    'export',
                                                                    'print'
                                                                ];
                                                            @endphp
                                                            @foreach($actions as $action)
                                                                <div class="col-lg-4 mt-2">
                                                                    <div class="form-check">
                                                                        <input
                                                                            class="form-check-input permission-checkbox"
                                                                            type="checkbox"
                                                                            name="permissions[]"
                                                                            value="{{ $action }}"
                                                                            id="{{ $action }}"
                                                                            {{ $action == 'list' ? 'checked' : '' }}
                                                                        />
                                                                        <label
                                                                            class="form-check-label text-capitalize"
                                                                            for="{{ $action }}">

                                                                            {{ str_replace('-', ' ', $action) }}

                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    <!--end::Col-->
                                                </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>

                                    <div class="col-12 mt-1 action-btn">
                                        <div class="demo-inline-spacing sub-btn">
                                            <button type="submit" data-url="{{ route('permissions.store') }}" class="btn btn-primary me-sm-3 me-1 submitBtn">Submit</button>
                                            <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                        <div class="demo-inline-spacing loading-btn" style="display: none;">
                                            <button class="btn btn-primary waves-effect waves-light" type="button" disabled="">
                                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                            <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <!--/ Add Permission Modal -->
        </div>
    <!-- Permission List Table -->
@endsection
@push('js')
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        function loadTable(){
            var table = $('.data_table').DataTable();
            if ($.fn.DataTable.isDataTable('.data_table')) {
                table.destroy();
            }
            var page_url = $('#page_url').val();
            var table = $('.data_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: page_url+"?loaddata=yes",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'permission_url', name: 'permission_url' },
                    { data: 'permission', name: 'permission' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' },
                ]
            });
        }
        $(document).ready(function() {
            loadTable();
        });
    </script>
@endpush
