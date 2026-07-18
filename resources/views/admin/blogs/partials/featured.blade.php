<label class="switch switch-warning">
    <input type="checkbox" class="switch-input changeFeatured" data-id="{{ $row->id }}" {{ $row->featured ? 'checked' : '' }}>
    <span class="switch-toggle-slider">
        <span class="switch-on">
            <i class="ti ti-star-filled"></i>
        </span>
        <span class="switch-off">
            <i class="ti ti-star"></i>
        </span>
    </span>
</label>
