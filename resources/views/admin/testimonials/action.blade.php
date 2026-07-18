<div class="dropdown">
    <button type="button"
        class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ti ti-dots-vertical fs-5"></i>
    </button>

    <ul class="dropdown-menu dropdown-menu-end">
        {{-- View --}}
        @can('testimonials-view')
            <li>
                <a class="dropdown-item" href="{{ route('testimonials.show', $row->id) }}">
                    <i class="ti ti-eye me-2 text-info"></i>
                    View
                </a>
            </li>
        @endcan
        {{-- Edit --}}
        @can('testimonials-edit')
            <li>
                <a class="dropdown-item" href="{{ route('testimonials.edit', $row->id) }}">
                    <i class="ti ti-edit me-2 text-warning"></i>
                    Edit
                </a>
            </li>
        @endcan
        @canany(['testimonials-view','testimonials-edit','testimonials-delete'])
            <li>
                <hr class="dropdown-divider">
            </li>
        @endcanany
        {{-- Delete --}}
        @can('testimonials-delete')
            <li>
                <a href="javascript:void(0)" class="dropdown-item text-danger deleteRecord" data-id="{{ $row->id }}">
                    <i class="ti ti-trash me-2"></i>
                    Delete
                </a>
            </li>
        @endcan
    </ul>
</div>
