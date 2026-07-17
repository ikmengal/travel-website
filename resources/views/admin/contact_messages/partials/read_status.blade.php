@if($row->is_read)
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)"
            class="toggleRead text-decoration-none"
            data-id="{{ $row->id }}"
            title="Mark as Unread">
            <span class="badge bg-label-success d-inline-flex align-items-center rounded p-2">
                <i class="ti ti-eye fs-3"></i>
            </span>
        </a>
        <strong class="text-success mx-1">Read</strong>
    </div>
@else
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)"
            class="toggleRead text-decoration-none"
            data-id="{{ $row->id }}"
            title="Mark as Read">

            <span class="badge bg-label-warning d-inline-flex align-items-center rounded p-2">
                <i class="ti ti-eye-off fs-3"></i>
            </span>
        </a>
        <strong class="text-warning mx-1">Unread</strong>
    </div>
@endif
