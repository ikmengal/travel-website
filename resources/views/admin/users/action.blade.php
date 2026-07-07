<div class="d-flex align-items-center">
    <a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
        <i class="ti ti-dots-vertical ti-xs mx-1"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end m-0">
        @can('admin_generate-password')
            <a href="javascript:;"
                class="dropdown-item mx-2 change-password-btn"
                data-toggle="tooltip"
                data-placement="top"
                title="Change Password"
                data-user-id="{{ $user->id }}"
                >
                Change Password
            </a>
        @endcan
        @can('users-view')
            <a href="{{ route('users.show', $user->id) }}"
                class="dropdown-item"
                type="button"
                title="User Details"
                >
                User Details
            </a>
        @endcan
        @can('users-edit')
            <a href="{{ route('users.edit', $user->id) }}"
                class="dropdown-item"
                title="Edit User"
                type="button"
                tabindex="0" aria-controls="DataTables_Table_0">
                Edit
            </a>
        @endcan
        @can('users-delete')
            <a href="javascript:;"
                class="dropdown-item delete"
                data-del-url="{{ route('users.destroy', $user->id) }}">
                Delete
            </a>
        @endcan
    </div>
</div>
