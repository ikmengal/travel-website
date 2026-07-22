<div class="d-inline-flex">
    @can('gallery-view')
        <a href="{{ route('gallery.show',$row->id) }}"
            class="btn btn-sm btn-icon btn-label-info me-1"
            title="View"
        >
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('gallery-edit')
        <a href="{{ route('gallery.edit',$row->id) }}"
            class="btn btn-sm btn-icon btn-label-primary me-1"
            title="Edit"
        >
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('gallery-delete')
        <button
            type="button"
            class="btn btn-sm btn-icon btn-label-danger deleteGallery"
            data-url="{{ route('gallery.destroy',$row->id) }}"
            title="Delete"
        >
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
