<div class="d-flex justify-content-start align-items-center user-name">
    <div class="avatar-wrapper">
        <div class="avatar avatar-md me-3">
            @if(!empty($user->profile_picture))
                <img src="{{ $user->profile_picture }}" alt="Avatar" class="rounded-circle img-avatar" style="object-fit: cover">
            @endif
        </div>
    </div>
    <div class="d-flex flex-column">
        <a href="javascrip:;" class="text-body text-truncate">
            <span class="fw-semibold">{{ $user->name ?? '-' }}</span>
        </a>
        <small class="emp_post text-truncate text-muted">
            {{ $user->email ?? '-' }}
        </small>
    </div>
</div>
