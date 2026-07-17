@php
    $name = $row->user?->name ?? $row->name ?? 'Guest';
    $initials = collect(explode(' ', trim($name)))
        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

<div class="d-flex align-items-center">
    <div class="avatar avatar-sm me-3">
        <span class="avatar-initial rounded-circle bg-label-primary fw-semibold">
            {{ $initials }}
        </span>
    </div>
    <div class="d-flex flex-column">
        <span class="fw-semibold text-body">
            {{ $name }}
        </span>
        @if($row->user)
            <small class="text-muted">
                Registered User
            </small>
        @else
            <small class="text-muted">
                Guest User
            </small>
        @endif
    </div>
</div>
