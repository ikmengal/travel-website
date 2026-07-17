{{-- @if($row->is_replied)
    <div class="d-flex align-items-center">
        <span class="badge bg-label-primary d-inline-flex align-items-center rounded p-2">
            <i class="ti ti-arrow-back-up fs-3"></i>
        </span>
        <strong class="text-primary mx-1">Replied</strong>
    </div>
@else
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)" class="replyMessage text-decoration-none"
            data-id="{{ $row->id }}" title="Reply Message">
            <span class="badge bg-label-warning d-inline-flex align-items-center rounded p-2">
                <i class="ti ti-arrow-back-up fs-3"></i>
            </span>
        </a>
        <strong class="text-warning mx-1">Pending</strong>
    </div>
@endif --}}

@if($row->is_replied)
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)"
            class="viewReply text-decoration-none"
            data-id="{{ $row->id }}"
            title="View Reply">

            <span class="badge bg-label-primary rounded p-2">
                <i class="ti ti-arrow-back-up fs-3"></i>
            </span>
        </a>
        <strong class="text-primary ms-2">
            Replied
        </strong>
    </div>
@else
    <div class="d-flex align-items-center">
        <a href="javascript:void(0)"
            class="replyMessage text-decoration-none"
            data-id="{{ $row->id }}"
            title="Reply Message">

            <span class="badge bg-label-warning rounded p-2">
                <i class="ti ti-arrow-back-up fs-3"></i>
            </span>
        </a>
        <strong class="text-warning ms-2">
            Pending
        </strong>
    </div>
@endif
