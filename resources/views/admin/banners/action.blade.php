<div class="d-flex justify-content-center gap-1">
    @can('banners-view')
        <a href="{{ route('banners.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('banners-edit')
        <a href="{{ route('banners.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-warning">
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('banners-delete')
        <button
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('banners.destroy', $row->id) }}">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
