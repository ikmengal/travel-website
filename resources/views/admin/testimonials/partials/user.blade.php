<div class="d-flex justify-content-start align-items-center user-name">
    <div class="avatar-wrapper">
        <div class="avatar avatar-lg me-3">
            @if($row->image && file_exists(public_path('images/testimonials/' . $row->image)))
                <img src="{{ asset('images/testimonials/' . $row->image) }}" alt="Avatar" class="rounded-circle img-avatar" style="object-fit: cover">
            @else
                <span class="avatar-initial rounded-circle bg-label-primary">
                    {{ strtoupper(substr($row->name,0,1)) }}
                </span>
            @endif
        </div>
    </div>
    <div class="d-flex flex-column">
        <a href="javascrip:;" class="text-body text-truncate">
            <span class="fw-semibold">{{ $row->name ?? '-' }}</span>
        </a>
        @if (isset($row->designation) && !empty($row->designation))
            <small class="emp_post text-truncate">
                {{ $row->designation ?? '-' }}
            </small>
        @endif
        @if (isset($row->company) && !empty($row->company))
            <small class="emp_post text-truncate text-muted">
                {{ $row->company ?? '-' }}
            </small>
        @endif

    </div>
</div>
