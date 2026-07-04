<form id="update-form" data-modal-id="editRoleModal" action="{{route('roles.update',$role->id)}}" class="row g-3">
    @csrf
    @method('PUT')
    <div class="col-12 mb-4">
        <label class="form-label" for="modalRoleName">Role Name</label>
        <input type="text" id="role" name="role" class="form-control" value="{{ $role->name ?? '' }}" placeholder="Enter a role name" tabindex="-1" />
        <span id="role_error" class="text-danger error"></span>
    </div>

    <div class="col-12">
        <h5>Role Permissions</h5>
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
                                <input class="form-check-input" type="checkbox" id="selectAll1" />
                                <label class="form-check-label" for="selectAll1"> Select All </label>
                            </div>
                        </td>
                    </tr>
                    @if(isset($permissions) && !blank($permissions))
                        @foreach($permissions as $label => $items)
                            <tr>
                                <td class="text-nowrap fw-semibold text-capitalize">{{ ucfirst($label) }} Management</td>
                                <td>
                                    <div class="d-flex">
                                        @if (!empty($items))
                                            @foreach($items as $permission)
                                            @php
                                                $action = str($permission->name)->afterLast('-');
                                            @endphp
                                                <div class="form-check me-3 me-lg-5">
                                                    <input class="form-check-input" type="checkbox" name="items[]" id="userManagementRead-{{ $permission->id }}" value="{{ $permission->name }}"
                                                        {{ in_array($permission->id,$rolePermissions) ? 'checked' : '' }}
                                                    />
                                                    <label class="form-check-label" for="userManagementRead-{{ $permission->id }}" >{{ ucfirst(str_replace('-', ' ', $action)) }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 text-center mt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>
<script>
    $(document).on('change','#selectAll1',function(){
        $('input:checkbox').prop('checked',$(this).is(':checked'));
    });
</script>
