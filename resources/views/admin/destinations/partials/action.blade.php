<div class="d-flex align-items-center">
    <a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
        <i class="ti ti-dots-vertical ti-xs mx-1"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end m-0">
        @can('destinations-view')
            <a href="{{ route('destinations.show',$destination->id) }}"
                class="dropdown-item mx-2 change-password-btn"
                type="button"
                >
                <i class="ti ti-eye me-2"></i>
                View
            </a>
        @endcan
        @can('destinations-edit')
            <a
                href="{{ route('destinations.edit',$destination->id) }}"
                class="dropdown-item"
                type="button"
                >
                <i class="ti ti-edit me-2"></i>
                Edit
            </a>
        @endcan
        @can('destinations-delete')
            <a
                href="javascript:void(0)"
                class="dropdown-item text-danger deleteRecord"
                data-url="{{ route('destinations.destroy',$destination->id) }}"
                >
                <i class="ti ti-trash me-2"></i>
                Delete
            </a>
        @endcan
    </div>
</div>
