<label class="switch switch-success">
    <input type="checkbox" class="switch-input status-switch {{ $class ?? 'status-switch' }}" data-id="{{ $id }}" {{ $checked ? 'checked' : '' }}>
    <span class="switch-toggle-slider">
        <span class="switch-on">
            <i class="ti ti-check"></i>
        </span>
        <span class="switch-off">
            <i class="ti ti-x"></i>
        </span>
    </span>
</label>
