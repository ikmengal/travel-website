<div class="d-inline-flex">
    @can('pages-view')
        <a href="{{ route('pages.show',$row->id) }}"
            class="btn btn-sm btn-icon btn-label-info me-1"
            title="View"
        >
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('pages-edit')
        <a href="{{ route('pages.edit',$row->id) }}"
            class="btn btn-sm btn-icon btn-label-primary me-1"
            title="Edit"
        >
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('pages-delete')
        <button
            type="button"
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('pages.destroy',$row->id) }}"
            title="Delete"
        >
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
