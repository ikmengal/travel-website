<div class="d-flex justify-content-center gap-1">
    @can('partners-view')
        <a href="{{ route('partners.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('partners-edit')
        <a href="{{ route('partners.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-warning">
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('partners-delete')
        <button
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('partners.destroy', $row->id) }}">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
