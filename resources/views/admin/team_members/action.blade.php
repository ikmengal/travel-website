<div class="d-flex justify-content-center">
    @can('team-members-view')
        <a href="{{ route('team_members.show', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-info me-1"
            title="View">
            <i class="ti ti-eye"></i>
        </a>
    @endcan
    @can('team-members-edit')
        <a href="{{ route('team_members.edit', $row->id) }}"
            class="btn btn-sm btn-icon btn-label-primary me-1"
            title="Edit">
            <i class="ti ti-edit"></i>
        </a>
    @endcan
    @can('team-members-delete')
        <button
            type="button"
            class="btn btn-sm btn-icon btn-label-danger deleteMember"
            data-url="{{ route('team_members.destroy', $row->id) }}"
            title="Delete">
            <i class="ti ti-trash"></i>
        </button>
    @endcan
</div>
