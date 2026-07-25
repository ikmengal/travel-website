<label class="switch switch-success mb-0">
    <input type="checkbox" class="switch-input changeStatus" data-id="{{ $destination->id }}" {{ $destination->status ? 'checked' : '' }}>
    <span class="switch-toggle-slider">
        <span class="switch-on">
            <i class="ti ti-check"></i>
        </span>
        <span class="switch-off">
            <i class="ti ti-x"></i>
        </span>
    </span>

    <span class="switch-label fw-semibold {{ $destination->status ? 'text-success' : 'text-danger' }}">
        {{ $destination->status ? 'Active' : 'Inactive' }}
    </span>
</label>
