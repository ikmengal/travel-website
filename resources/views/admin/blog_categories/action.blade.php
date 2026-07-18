<div class="d-flex justify-content-center gap-1">
    @can('blog-category-view')
        <a href="{{ route('blog_categories.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info"
            title="View">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('blog-category-edit')
        <a href="{{ route('blog_categories.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-warning"
            title="Edit">
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('blog-category-delete')
        <button
            type="button"
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('blog_categories.destroy', $row->id) }}"
            title="Delete">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
