<div class="dropdown">
    <button type="button" data-bs-toggle="dropdown"
            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow">
        <i class="ti ti-dots-vertical"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
            @can('contacts-view')
                <a href="{{ route('contact_messages.show',$row->id) }}" class="dropdown-item">
                    <i class="ti ti-eye me-2 text-info"></i>
                    View Details
                </a>
            @endcan
            @can('contacts-delete')
                <a href="javascript:void(0)" class="dropdown-item text-danger deleteRecord" data-id="{{ $row->id }}">
                    <i class="ti ti-trash me-2"></i>
                    Delete
                </a>
            @endcan
        </div>
    </div>
</div>
