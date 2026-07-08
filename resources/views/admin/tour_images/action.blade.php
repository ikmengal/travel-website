<div class="dropdown">
    <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
        <i class="ti ti-dots-vertical"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        @can('tour-images-view')
            <a href="{{ route('tour_images.show',$row->id) }}" class="dropdown-item">
                <i class="ti ti-eye me-2"></i>
                View
            </a>
        @endcan

        @can('tour-images-edit')
            <a href="{{ route('tour_images.edit',$row->id) }}" class="dropdown-item">
                <i class="ti ti-edit me-2"></i>
                Edit
            </a>
        @endcan

        @can('tour-images-delete')
            <a href="javascript:void(0)" data-url="{{ route('tour_images.destroy',$row->id) }}" class="dropdown-item deleteRecord">
                <i class="ti ti-trash me-2"></i>
                Delete
            </a>
        @endcan
    </div>
</div>
