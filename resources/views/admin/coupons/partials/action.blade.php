<div class="d-flex align-items-center gap-1">
    @can('coupons-view')
        <a href="{{ route('coupons.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info"
            title="View"
        >
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('coupons-edit')
        <a href="{{ route('coupons.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-warning"
            title="Edit"
        >
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('coupons-edit')
        <div class="form-check form-switch ms-1">
            <input class="form-check-input changeStatus" type="checkbox" data-id="{{ $row->id }}" {{ $row->status ? 'checked' : '' }}>
        </div>
    @endcan
    @can('coupons-delete')
        <button type="button" class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-id="{{ $row->id }}" title="Delete">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
