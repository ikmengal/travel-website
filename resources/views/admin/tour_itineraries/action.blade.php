<div class="dropdown">
    <button type="button" data-bs-toggle="dropdown"
        class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow">
        <i class="ti ti-dots-vertical"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-end">
        @can('tour-itineraries-view')
            <a href="{{ route('tour_itineraries.show',$row->id) }}" class="dropdown-item">
                <i class="ti ti-eye me-2 text-info"></i>
                View
            </a>
        @endcan
        @can('tour-itineraries-edit')
            <a href="{{ route('tour_itineraries.edit',$row->id) }}" class="dropdown-item">
                <i class="ti ti-edit me-2 text-warning"></i>
                Edit
            </a>
        @endcan
        @can('tour-itineraries-delete')
            <a href="javascript:void(0)" class="dropdown-item deleteRecord"
                data-url="{{ route('tour_itineraries.destroy',$row->id) }}">
                <i class="ti ti-trash me-2 text-danger"></i>
                Delete
            </a>
        @endcan
    </div>
</div>
