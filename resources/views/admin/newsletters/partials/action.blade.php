<div class="d-inline-flex">
    @can('newsletters-view')
        <a href="{{ route('newsletter_subscribers.show',$row->id) }}"
        class="btn btn-sm badge bg-label-secondary rounded p-2"
        title="View">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('newsletters-edit')
        <a href="{{ route('newsletter_subscribers.edit',$row->id) }}"
        class="btn btn-sm badge bg-label-primary rounded p-2 me-1"
        title="Edit">
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('newsletters-delete')
        <button
            type="button"
            class="btn btn-sm badge bg-label-danger rounded p-2 deleteRecord"
            data-id="{{ $row->id }}"
            title="Delete">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
