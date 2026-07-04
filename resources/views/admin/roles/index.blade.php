@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    <div class="card mb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Home /</span>All Roles</h4>
                    <hr />
                    <p class="mb-4">
                        A role provided access to predefined menus and features so that depending on
                        <br>
                        assigned role an administrator can have access to what user needs.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Role cards -->
        <div class="row g-4">
            @if(isset($roles) && !blank($roles))
                @foreach ($roles as $role)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal mb-2">Total {{ count($role->users) ?? 0 }} users</h6>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">

                                    @foreach($role->users->take(5) as $user)
                                        <li
                                            class="avatar avatar-sm pull-up"
                                            data-bs-toggle="tooltip"
                                            title="{{ $user->name }}"
                                        >
                                            <img
                                                class="rounded-circle"
                                                src="{{ $user->avatar ? asset('images/users/'.$user->avatar) : asset('images/users/user1.png') }}"
                                                alt="{{ $user->name }}">
                                        </li>
                                    @endforeach

                                    @if($role->users->count() > 5)
                                        <li class="avatar avatar-sm">
                                            <span class="avatar-initial rounded-circle bg-label-secondary">
                                                +{{ $role->users->count() - 5 }}
                                            </span>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-1">
                                <div class="role-heading">
                                <h4 class="mb-1 text-capitalize">{{ $role->name ?? '-' }}</h4>
                                <a
                                    href="javascript:;"
                                    class="role-edit-modal"
                                    data-url={{ route('roles.edit', $role->id)}}
                                    id="edit-btn"
                                >
                                    <span>Edit Role</span>
                                </a>
                                </div>
                                <a href="javascript:void(0);" class="text-danger delete-role"
                                    data-id="{{ $role->id }}"
                                    data-url="{{ route('roles.destroy', $role->id) }}">
                                    <i class="ti ti-trash ti-md"></i>
                                </a>
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                            <img
                                src="{{asset('admin/assets/img/illustrations/add-new-roles.png') }}"
                                class="img-fluid mt-sm-4 mt-md-0"
                                alt="add-new-roles"
                                width="83"
                            />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                @can('roles-create')
                                    <button
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Add New Role"
                                        data-url="{{ route('roles.store') }}"
                                        class="btn add-new btn-primary mb-3 mb-md-0 mx-3"
                                        tabindex="0"
                                        aria-controls="DataTables_Table_0"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addRoleModal">
                                        Add New Role
                                    </button>
                                    <p class="mb-0 mt-1">Add role, if it does not exist</p>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--/ Role cards -->

    <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
                <div class="modal-content p-3 p-md-5">
                    <button
                        type="button"
                        class="btn-close btn-pinned"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3 class="role-title mb-2"></h3>
                            <p class="text-muted">Set role permissions</p>
                        </div>
                        <!-- Add role form -->
                            <form id="create-form" data-modal-id="addRoleModal" action="" class="row g-3">
                                @csrf
                                <div class="col-12 mb-4">
                                    <label class="form-label" for="modalRoleName">Role Name</label>
                                    <input type="text" id="role" name="role" class="form-control" placeholder="Enter a role name" tabindex="-1" />
                                    <span id="role_error" class="text-danger error"></span>
                                </div>
                                <div class="col-12">
                                    <h5>Role Permissions</h5>
                                    <!-- Permission table -->
                                        <div class="table-responsive">
                                            <table class="table table-flush-spacing">
                                                <tbody>
                                                <tr>
                                                    <td class="text-nowrap fw-semibold">
                                                        Administrator Access
                                                        <i class="ti ti-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system"></i>
                                                    </td>
                                                    <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                                        <label class="form-check-label" for="selectAll"> Select All </label>
                                                        <span id="item_error" class="text-danger"></span>
                                                    </div>
                                                    </td>
                                                </tr>
                                                @if(isset($permissions) && !blank($permissions))
                                                    @foreach($permissions as $module => $items)
                                                        <tr>
                                                            <td class="text-nowrap fw-semibold text-capitalize">
                                                                {{ ucfirst(str_replace('-', ' ', $module)) }} Management
                                                            </td>
                                                            <td>
                                                            <div class="d-flex">
                                                                @foreach($items as $permission)
                                                                    @php
                                                                        $action = explode('-', $permission->name)[1];
                                                                    @endphp
                                                                    <div class="form-check me-3 me-lg-5">
                                                                        <input class="form-check-input" type="checkbox" name="items[]" id="userManagementRead-{{ $permission->id }}" value="{{ $permission->id }}" />
                                                                        <label class="form-check-label" for="userManagementRead-{{ $permission->id }}"> {{ ucfirst($action) }} </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    <!-- Permission table -->
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                </div>
                            </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
        </div>
    <!--/ Add Role Modal -->

    <!-- Edit Role Modal -->
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
                <div class="modal-content p-3 p-md-5">
                    <button
                        type="button"
                        class="btn-close btn-pinned"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3 class="role-title mb-2">Edit Role</h3>
                            <p class="text-muted">Set Role Permissions</p>
                        </div>
                        <div id="edit-form">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--/ Edit Role Modal -->
@endsection
@push('js')
    <script>
        $("#selectAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).ready(function() {
            $(document).on('submit', '#create-form', function(e){
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                showFancyBox();
                $.ajax({
                    type:'POST',
                    url: url,
                    data: $('#create-form').serialize(),
                    success: function(response) {
                        if(response.success && response.success == true) {
                            hideFancyBox();
                            toastr.success(response.message);
                            location.reload();
                            $('#create-form')[0].reset();
                            $("#addRoleModal").modal('hide');
                        }

                        if (response.success && response.success === false) {
                            console.log("One" + response);
                            hideFancyBox();
                            $(".custom_error").html("")
                            $.each(response.message, function (index, value) {
                                console.log("Two" + response);
                                showFancyBox();
                                const fieldName = index;
                                const errorElement = $(`#${fieldName}_error`);
                                console.log(`#${fieldName}_error`);
                                $(`#${fieldName}_error`).html(value[0])
                                errorElement.html(value[0]);
                            });
                        }

                        if(response.error) {
                            hideFancyBox();
                            $("#role_error").text(response.error);
                        }
                    },

                    error: function(xhr, status, error) {
                        hideFancyBox();
                        var errors = JSON.parse(xhr.responseText);
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').empty();
                        $('.error').empty();
                        $.each(errors.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    },
                });
            });

            $(document).on('submit', '#update-form', function(e){
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                showFancyBox();
                $.ajax({
                    type:'POST',
                    url: url,
                    data: $('#update-form').serialize(),
                    success: function(response) {
                        if(response.success && response.success == true) {
                            hideFancyBox();
                            toastr.success(response.message);
                            location.reload();
                            $('#update-form')[0].reset();
                            $("#editRoleModal").modal('hide');
                        }

                        if (response.success && response.success === false) {
                            hideFancyBox();
                            console.log("Message False");
                            $(".custom_error").html("")
                            $.each(response.message, function (index, value) {
                                const fieldName = index;
                                const errorElement = $(`#${fieldName}_error`);
                                console.log(`#${fieldName}_error`);
                                $(`#${fieldName}_error`).html(value[0])
                                errorElement.html(value[0]);
                            });
                        }

                        if(response.error) {
                            hideFancyBox();
                            $("#role_error").text(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        hideFancyBox();
                        var errors = JSON.parse(xhr.responseText);
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').empty();
                        $('.error').empty();
                        $.each(errors.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    },
                });
            });
        });

        $(document).on('click', '.add-new', function(){
            var url = $(this).data('url');
            var title = $(this).attr('title');
            var model = $(this).attr('data-bs-target');

            $(model).find('.role-title').html(title);
            $(model).find('#create-from').attr('action', url);
            $(model).find('#create-from').attr('data-method', "POST");

            $(model).find('form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();
            $('.error').empty();

            $(model).find('input[type="text"], input[type="number"], input[type="date"], input[type="email"], input[type="time"], textarea').val('');
            $(model).find('select').val(null).trigger('change');
            $(model).find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
            $(model).find('#attachment-file').html('');
        });

        $(document).on('click', '#edit-btn', function(){
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $("#edit-form").empty();
                    $("#edit-form").append(response);
                    $("#editRoleModal").modal('show');
                }
            });
        });

        $(document).on('click', '.delete-role', function () {
            let url = $(this).data('url');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function (response) {
                            toastr.success(response.message);
                            location.reload();
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            })
        });
    </script>
@endpush
