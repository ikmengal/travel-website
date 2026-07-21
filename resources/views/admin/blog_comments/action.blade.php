<div class="d-flex justify-content-center gap-1">
    @can('blog-comments-view')
        <a href="{{ route('blog_comments.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('blog-comments-edit')
        <a href="{{ route('blog_comments.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-warning">
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('blog-comments-delete')
        <button
            class="btn btn-sm btn-icon btn-label-danger deleteRecord"
            data-url="{{ route('blog_comments.destroy', $row->id) }}">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
