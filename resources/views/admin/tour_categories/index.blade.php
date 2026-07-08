@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="card mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card-header">
                    <h4 class="fw-bold mb-0"><span class="text-muted fw-light"> Home /</span> {{ $title ?? '' }} </h4>
                </div>
            </div>
            @canany(['tour-category-list'])
                <div class="col-md-6">
                    <div class="dt-buttons btn-group flex-wrap float-end mt-4">
                        @can('tour-category-create')
                            <button
                                id="add-btn"
                                data-toggle="tooltip" data-placement="top"
                                data-url="{{ route('tour_categories.store') }}"
                                data-create-url="{{ route('tour_categories.create') }}"
                                class="btn add-new btn-primary mb-3 mb-md-0 mx-3"
                                tabindex="0" aria-controls="DataTables_Table_0"
                                type="button" data-bs-toggle="modal"
                                title="Add Tour Category"
                                data-bs-target="#addUserModal">
                                <span>
                                    <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add Tour Category </span>
                                </span>
                            </button>
                        @endcan
                    </div>
                </div>
            @endcanany
        </div>
    </div>

    <!-- User List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container-fluid">
                        <table class="destinationTable table border-top dataTable no-footer dtr-column data_table table-responsive"
                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 1227px; display:table;">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="checkAll" class="form-check-input">
                                    </th>
                                    <th>S No</th>
                                    <th>icon</th>
                                    <th>status</th>
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
                            <h3 class="mb-2" id="modal-label">Add Tour Category</h3>
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
    @include('admin.tour_categories.scripts')
@endpush
