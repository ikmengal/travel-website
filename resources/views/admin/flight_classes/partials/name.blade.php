<div class="d-flex flex-column">
    <span class="fw-semibold">
        {{ $row->name }}
    </span>

    <small class="text-muted">
        {{ $row->slug }}
    </small>

    @if($row->description)
        <small class="text-muted mt-1">
            {{ \Illuminate\Support\Str::limit(strip_tags($row->description),60) }}
        </small>
    @endif
</div>
