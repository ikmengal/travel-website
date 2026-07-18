<div class="d-flex justify-content-center gap-1">
    @can('blogs-view')
        <a href="{{ route('blogs.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('blogs-edit')
        <a href="{{ route('blogs.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-warning">
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('blogs-delete')
        <button
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('blogs.destroy', $row->id) }}">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
