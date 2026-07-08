<div class="dropdown">
    <button
        class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
        data-bs-toggle="dropdown"
        type="button">
        <i class="ti ti-dots-vertical"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        {{-- View --}}
        @can('tours-view')
            <li>
                <a class="dropdown-item"
                   href="{{ route('tours.show', $row->id) }}">
                    <i class="ti ti-eye me-2 text-info"></i>
                    View
                </a>
            </li>
        @endcan
        {{-- Edit --}}
        @can('tours-edit')
            <li>
                <a class="dropdown-item"
                   href="{{ route('tours.edit', $row->id) }}">
                    <i class="ti ti-edit me-2 text-warning"></i>
                    Edit
                </a>
            </li>
        @endcan
        @canany(['tours-show','tours-edit'])
            <li>
                <hr class="dropdown-divider">
            </li>
        @endcanany
        {{-- Delete --}}
        @can('tours-delete')
            <li>
                <a href="javascript:void(0);"
                   class="dropdown-item text-danger deleteRecord"
                   data-url="{{ route('tours.destroy', $row->id) }}">
                    <i class="ti ti-trash me-2"></i>
                    Delete
                </a>
            </li>
        @endcan
    </ul>
</div>
