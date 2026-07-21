<div class="d-flex justify-content-center gap-1">
    @can('blog-tags-view')
        <a href="{{ route('blog_tags.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('blog-tags-edit')
        <a href="{{ route('blog_tags.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-warning">
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('blog-tags-delete')
        <button
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('blog_tags.destroy', $row->id) }}">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
