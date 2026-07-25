<div class="d-inline-flex">

    @can('airlines-view')

        <a
            href="{{ route('airlines.show',$row->id) }}"
            class="btn btn-sm btn-icon btn-label-info me-1"
            title="View">

            <i class="ti ti-eye"></i>

        </a>

    @endcan

    @can('airlines-edit')

        <a
            href="{{ route('airlines.edit',$row->id) }}"
            class="btn btn-sm btn-icon btn-label-primary me-1"
            title="Edit">

            <i class="ti ti-edit"></i>

        </a>

    @endcan

    @can('airlines-delete')

        <button
            type="button"
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('airlines.destroy',$row->id) }}"
            title="Delete">

            <i class="ti ti-trash"></i>

        </button>

    @endcan

</div>
