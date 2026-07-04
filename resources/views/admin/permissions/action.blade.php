<div class="d-flex align-items-center">
    <a data-toggle="tooltip" data-placement="top" title="Delete Record" href="javascript:;" class="btn btn-icon btn-label-danger waves-effect delete" data-slug="{{ $permission->label }}" data-del-url="{{ route('permissions.destroy', $permission->label) }}">
        <i class="ti ti-trash ti-xs mx-2"></i>
    </a>
</div>
