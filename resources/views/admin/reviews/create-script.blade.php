<div class="dropdown">
    <button type="button" data-bs-toggle="dropdown"
            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow">
        <i class="ti ti-dots-vertical"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        @can('reviews-view')
            <a href="{{ route('reviews.show', $row->id) }}" class="dropdown-item">
                <i class="ti ti-eye me-2 text-info"></i>
                View
            </a>
        @endcan
        @can('reviews-edit')
            <a href="{{ route('reviews.edit', $row->id) }}" class="dropdown-item">
                <i class="ti ti-edit me-2 text-warning"></i>
                Edit
            </a>
        @endcan
        @canany(['reviews-delete'])
            <div class="dropdown-divider"></div>
        @endcanany
        @can('reviews-delete')
            <a href="javascript:void(0);" class="dropdown-item text-danger deleteRecord" data-url="{{ route('reviews.destroy', $row->id) }}">
                <i class="ti ti-trash me-2"></i>
                Delete
            </a>
        @endcan
    </div>
</div>
