<div class="d-flex align-items-center">
    <a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
        <i class="ti ti-dots-vertical ti-xs mx-1"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end m-0">
        @can('tour-category-view')
            <a href="#"
                class="dropdown-item show"
                tabindex="0" aria-controls="DataTables_Table_0"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#details-modal"
                data-toggle="tooltip"
                data-placement="top"
                title="Tour Category Detail"
                data-show-url="{{ route('tour_categories.show', $query->id) }}"
                >
                Tour Category Details
            </a>
        @endcan
        @can('tour-category-edit')
            <a href="#"
                class="dropdown-item edit-btn"
                data-toggle="tooltip"
                data-placement="top"
                title="Tour Category Edit"
                data-edit-url="{{ route('tour_categories.edit', $query->id) }}"
                data-url="{{ route('tour_categories.update', $query->id) }}"
                type="button"
                tabindex="0" aria-controls="DataTables_Table_0"
                type="button" data-bs-toggle="modal"
                data-bs-target="#addUserModal"
                >
                Edit
            </a>
        @endcan
        @can('tour-category-delete')
            <a href="javascript:;"
                class="dropdown-item delete"
                data-del-url="{{ route('tour_categories.destroy', $query->id) }}">
                Delete
            </a>
        @endcan
    </div>
</div>

