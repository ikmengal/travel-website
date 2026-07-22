<div class="row">
    {{-- Partner Name --}}
    <div class="col-md-6 mb-3">
        <label class="form-label"> Partner Name<span class="text-danger">*</span></label>
        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $partner->name ?? '') }}"
        >
        <small class="text-danger error-text name_error"></small>
    </div>

    {{-- Website --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Website</label>
        <input
            type="url"
            name="website"
            class="form-control"
            placeholder="https://example.com"
            value="{{ old('website', $partner->website ?? '') }}"
        >
        <small class="text-danger error-text website_error"></small>
    </div>

    {{-- Logo --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Logo</label>
        <input
            type="file"
            name="logo"
            id="logo"
            class="form-control"
            accept=".jpg,.jpeg,.png,.webp"
        >
        <small class="text-danger error-text logo_error"></small>
    </div>

    {{-- Preview --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Current Logo</label>
        <div>
            <img
                id="logoPreview"
                src="{{ isset($partner->logo) && !empty($partner->logo) ? asset('images/partners/'.$partner->logo) : asset('admin/assets/img/1.png') }}"
                class="rounded border"
                style="max-width:140px; max-height:140px; object-fit:contain;">
        </div>
    </div>

    {{-- Sort Order --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Sort Order</label>
        <input
            type="number"
            name="sort_order"
            class="form-control"
            min="0"
            value="{{ old('sort_order', $partner->sort_order ?? 0) }}"
        >
        <small class="text-danger error-text sort_order_error"></small>
    </div>

    {{-- Featured --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Featured</label>
        <select name="featured" class="form-select select2">
            <option value="0"
                {{ old('featured', $partner->featured) ? 'selected' : '' }}>
                No
            </option>
            <option value="1"
                {{ old('featured', $partner->featured) ? 'selected' : '' }}>
                Yes
            </option>
        </select>
        <small class="text-danger error-text featured_error"></small>
    </div>

    {{-- Status --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select select2">
            <option value="1"
                {{ old('status', $partner->status) ? 'selected' : '' }}>
                Active
            </option>
            <option value="0"
                {{ !old('status', $partner->status) ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
        <small class="text-danger error-text status_error"></small>
    </div>
</div>

<hr>

<div class="d-flex justify-content-end">
    <a href="{{ route('partners.index') }}" class="btn btn-label-secondary me-2">
        Cancel
    </a>

    <button type="submit" id="submitBtn" class="btn btn-primary">
        <i class="ti ti-device-floppy me-1"></i>
        {{ isset($partner) && !empty($partner) ? 'Update Partner' : 'Save Partner' }}
    </button>
</div>
