<div class="d-flex justify-content-center">
    @can('counters-view')
        <a href="{{ route('counters.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info me-1"
            title="View">

            <i class="ti ti-eye"></i>

        </a>
    @endcan
    @can('counters-edit')
        <a href="{{ route('counters.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-primary me-1"
            title="Edit">

            <i class="ti ti-edit"></i>

        </a>
    @endcan
    @can('counters-delete')
        <button
            type="button"
            class="btn btn-sm btn-icon btn-label-danger deleteCounter"
            data-url="{{ route('counters.destroy', $row->id) }}"
            title="Delete">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
