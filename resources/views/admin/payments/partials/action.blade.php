<div class="dropdown">
    <button
        class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
        data-bs-toggle="dropdown">
        <i class="ti ti-dots-vertical"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-end">
        @can('payments-view')
            <a href="{{ route('payments.show',$row->id) }}" class="dropdown-item">
                <i class="ti ti-eye me-2 text-info"></i>
                View
            </a>
        @endcan
        @can('payments-edit')
            <a href="{{ route('payments.edit',$row->id) }}" class="dropdown-item">
                <i class="ti ti-edit me-2 text-warning"></i>
                Edit
            </a>
        @endcan
        @can('payments-delete')
            <button type="button" data-id="{{ $row->id }}" class="dropdown-item deleteRecord">
                <i class="ti ti-trash me-2 text-danger"></i>
                Delete
            </button>
        @endcan
    </div>
</div>
