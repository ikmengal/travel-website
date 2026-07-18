<label class="switch switch-warning mb-0">
    <input type="checkbox" class="switch-input changeFeatured"
        data-id="{{ $row->id }}" {{ $row->featured ? 'checked' : '' }}>
    <span class="switch-toggle-slider">
        <span class="switch-on">
            <i class="ti ti-star-filled"></i>
        </span>
        <span class="switch-off">
            <i class="ti ti-star"></i>
        </span>
    </span>
    <span class="switch-label fw-semibold {{ $row->featured ? 'text-warning' : 'text-muted' }}">
        {{ $row->featured ? 'Featured' : 'Normal' }}
    </span>
</label>
