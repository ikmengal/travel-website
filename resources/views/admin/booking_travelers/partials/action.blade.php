<div class="dropdown">
    <button type="button" data-bs-toggle="dropdown"
            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow">
        <i class="ti ti-dots-vertical"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        @can('booking-travelers-view')
            <a href="{{ route('booking_travelers.show', $row->id) }}" class="dropdown-item">
                <i class="ti ti-eye me-2 text-info"></i>
                View
            </a>
        @endcan
        @can('booking-travelers-edit')
            <a href="{{ route('booking_travelers.edit', $row->id) }}" class="dropdown-item">
                <i class="ti ti-edit me-2 text-warning"></i>
                Edit
            </a>
        @endcan
        @canany(['booking-travelers-delete'])
            <div class="dropdown-divider"></div>
        @endcanany
        @can('booking-travelers-delete')
            <a href="javascript:void(0);" class="dropdown-item text-danger delete" data-del-url="{{ route('booking_travelers.destroy', $row->id) }}">
                <i class="ti ti-trash me-2"></i>
                Delete
            </a>
        @endcan
    </div>
</div>
