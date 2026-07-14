<div class="dropdown">
    <button type="button" data-bs-toggle="dropdown"
            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow">
        <i class="ti ti-dots-vertical"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        @can('bookings-view')
            <a href="{{ route('bookings.show', $row->id) }}" class="dropdown-item">
                <i class="ti ti-eye me-2 text-info"></i>
                View
            </a>
        @endcan
        @can('bookings-edit')
            <a href="{{ route('bookings.edit', $row->id) }}" class="dropdown-item">
                <i class="ti ti-edit me-2 text-warning"></i>
                Edit
            </a>
        @endcan
        @canany(['bookings-delete'])
            <div class="dropdown-divider"></div>
        @endcanany
        @can('bookings-delete')
            <a href="javascript:void(0);" class="dropdown-item text-danger deleteRecord" data-url="{{ route('bookings.destroy', $row->id) }}">
                <i class="ti ti-trash me-2"></i>
                Delete
            </a>
        @endcan
    </div>
</div>
