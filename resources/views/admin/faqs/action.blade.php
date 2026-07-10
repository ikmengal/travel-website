<div class="dropdown">
    <button type="button" data-bs-toggle="dropdown"
            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow">
        <i class="ti ti-dots-vertical"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        @can('faqs-view')
            <a href="{{ route('faqs.show', $row->id) }}" class="dropdown-item">
                <i class="ti ti-eye me-2 text-info"></i>
                View
            </a>
        @endcan
        @can('faqs-edit')
            <a href="{{ route('faqs.edit', $row->id) }}" class="dropdown-item">
                <i class="ti ti-edit me-2 text-warning"></i>
                Edit
            </a>
        @endcan
        @canany(['faqs-delete'])
            <div class="dropdown-divider"></div>
        @endcanany
        @can('faqs-delete')
            <a href="javascript:void(0);" class="dropdown-item text-danger deleteRecord" data-url="{{ route('faqs.destroy', $row->id) }}">
                <i class="ti ti-trash me-2"></i>
                Delete
            </a>
        @endcan
    </div>
</div>
