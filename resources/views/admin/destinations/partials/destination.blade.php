<div class="d-flex align-items-center">
    <div>
        <h6 class="mb-0">
            {{ $destination->name }}
        </h6>
        @if($destination->tagline)
            <small class="text-muted">
                {{ Str::limit($destination->tagline,50) }}
            </small>
        @endif
        <div class="mt-1">
            <span class="badge bg-label-secondary">
                {{ $destination->slug }}
            </span>
        </div>
    </div>
</div>
