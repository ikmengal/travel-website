<div class="d-inline-flex">
    @can('flight-classes-view')
        <a href="{{ route('flight_classes.show',$row->id) }}"
            class="btn btn-sm btn-icon btn-label-info me-1"
            title="View">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('flight-classes-edit')
        <a href="{{ route('flight_classes.edit',$row->id) }}"
            class="btn btn-sm btn-icon btn-label-primary me-1"
            title="Edit">

            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('flight-classes-delete')
        <button
            type="button"
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('flight_classes.destroy',$row->id) }}"
            title="Delete">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
