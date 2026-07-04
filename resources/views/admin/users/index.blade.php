@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    @if(request()->is('users/trashed'))
        <input type="hidden" id="page_url" value="{{ route('users.trashed') }}">
    @else
        <input type="hidden" id="page_url" value="{{ route('users.index') }}">
    @endif
    <div class="card mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card-header">
                    <h4 class="fw-bold mb-0"><span class="text-muted fw-light"> Home /</span> User Management</h4>
                </div>
            </div>
            @canany(['users-create','users-trashed', 'users-list'])
                <div class="col-md-6">
                    @if(request()->is('users/trashed'))
                        @can('users-list')
                            <div class="dt-buttons btn-group flex-wrap float-end mt-4">
                                <a data-toggle="tooltip" data-placement="top" title="View ALl Records" href="{{ route('users.index') }}" class="btn btn-success btn-primary mx-3">
                                    <span>
                                        <i class="ti ti-eye me-0 me-sm-1 ti-xs"></i>
                                        <span class="d-none d-sm-inline-block">{{ __('messages.all_records') }}</span>
                                    </span>
                                </a>
                            </div>
                        @endcan
                    @else
                        <div class="dt-buttons btn-group flex-wrap float-end mt-4">
                            @can('users-create')
                                {{-- <button
                                    id="add-btn"
                                    data-toggle="tooltip" data-placement="top"
                                    data-url="{{ route('users.store') }}"
                                    data-create-url="{{ route('users.create') }}"
                                    class="btn add-new btn-primary mb-3 mb-md-0 mx-3"
                                    tabindex="0" aria-controls="DataTables_Table_0"
                                    type="button" data-bs-toggle="modal"
                                    title="Add User"
                                    data-bs-target="#addUserModal">
                                    <span>
                                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                        <span class="d-none d-sm-inline-block"> Add User </span>
                                    </span>
                                </button> --}}
                                <a href="{{ route('users.create') }}" class="menu-link">
                                    <div data-i18n="create user">Add User</div>
                                </a>
                            @endcan
                        </div>
                        @can('users-trashed')
                            <div class="dt-buttons btn-group flex-wrap float-end mt-4">
                                <a data-toggle="tooltip" data-placement="top" title="View All Trashed Records" href="{{ route('users.trashed') }}" class="btn btn-label-danger mx-1">
                                    <span>
                                        <i class="ti ti-trash me-0 me-sm-1 ti-xs"></i>
                                        <span class="d-none d-sm-inline-block">View all trashed records</span>
                                    </span>
                                </a>
                            </div>
                        @endcan
                    @endif
                </div>
            @endcanany
        </div>
    </div>

    <!-- User List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container-fluid">
                        <table class="datatables-users table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 1227px;">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- User List Table -->

    <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content p-3 p-md-5">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3 class="mb-2" id="modal-label">Add User</h3>
                        </div>
                        <form id="create-form" data-modal-id="addUserModal" class="row submitBtnWithFileUpload" data-method="" action="" enctype="multipart/form-data">
                            @csrf

                            <div id="edit-content"></div>

                            <div class="col-12 action-btn">
                                <div class="demo-inline-spacing sub-btn">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
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
    <!--/ Add User Modal -->

    <div class="modal fade" id="details-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered1 modal-simple modal-add-new-cc">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2" id="modal-label"></h3>
                    </div>

                    <div class="col-12">
                        <span id="show-content"></span>
                    </div>

                    <div class="col-12 mt-3 text-end">
                        <button type="reset" class="btn btn-label-primary btn-reset" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
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
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
                    {data: 'name', name: 'name'},
                    {data: 'role', name: 'roles.name', orderable:false, searchable:false},
                    {data: 'phone', name: 'phone'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable:false, searchable:false},
                ]
            });
        }

        $(document).ready(function() {
            // Button click event to copy code to clipboard
                $('#copyButton').click(function() {
                    // Select the input field
                    var inputField = $('#input-password')[0];
                    // Select the text within the input field
                    inputField.select();
                    // Copy the selected text
                    document.execCommand('copy');
                    // Optionally, you can provide feedback to the user
                    $(this).html('Copied!');
                });
            //change password

            loadTable();
            selectInit();
        });

        function selectInit() {
            setTimeout(() => {
                $('select').each(function() {
                    $(this).select2({
                        dropdownParent: $(this).parent(),
                    });
                });
            }, 1000);
        }
    </script>
@endpush
