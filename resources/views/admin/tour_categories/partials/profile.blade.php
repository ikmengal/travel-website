<div class="d-flex justify-content-start align-items-center user-name">
    <div class="avatar-wrapper">
        <div class="avatar avatar-md me-3">
            <i class="{{$query->icon ?? 'ti ti-dummy'}} fs-1" style="color:{{ $query->color ?? 'primary' }}"></i>
        </div>
    </div>
    <div class="d-flex flex-column">
        <a href="javascrip:;" class="text-body text-truncate">
            <span class="fw-semibold">{{ $query->name ?? '-' }}</span>
        </a>
        <small class="emp_post text-truncate text-muted">
            {{ $query->slug ?? '-' }}
        </small>
    </div>
</div>
