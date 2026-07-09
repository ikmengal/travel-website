<div class="dropdown">
    <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
        <i class="ti ti-dots-vertical"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-end">
        @can('tour-departures-view')
            <a class="dropdown-item" href="{{ route('tour_departures.show',$row->id) }}">
                <i class="ti ti-eye me-2 text-info"></i>
                View
            </a>
        @endcan
        @can('tour-departures-edit')
            <a class="dropdown-item" href="{{ route('tour_departures.edit',$row->id) }}">
                <i class="ti ti-edit me-2 text-warning"></i>
                Edit
            </a>
        @endcan
        @can('tour-departures-delete')
            <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" class="dropdown-item text-danger deleteRecord"data-url="{{ route('tour_departures.destroy',$row->id) }}">
                <i class="ti ti-trash me-2"></i>
                Delete
            </a>
        @endcan
    </div>
</div>
