<form id="counterForm">
    @csrf
    <div class="row">
        {{-- Icon --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Icon <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">
                    <i id="iconPreview" class="{{ old('icon', $counter->icon ?? 'ti ti-users') }} fs-4"></i>
                </span>
                <input type="text" name="icon" id="icon" class="form-control"
                    value="{{ old('icon', $counter->icon ?? 'ti ti-users') }}"
                    placeholder="ti ti-users">
            </div>
            <small class="text-muted">
                Examples:
                <strong>
                    ti ti-users,
                    ti ti-world,
                    ti ti-plane,
                    ti ti-map-pin,
                    ti ti-award,
                    ti ti-building
                </strong>
            </small>
            <br>
            <small class="text-danger error-text icon_error"></small>
        </div>

        {{-- Title --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control"
                value="{{ old('title', $counter->title ?? '') }}"
                placeholder="Happy Travelers">
            <small class="text-danger error-text title_error"></small>
        </div>

        {{-- Prefix --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Prefix</label>
            <input type="text" name="prefix" class="form-control" value="{{ old('prefix', $counter->prefix ?? '') }}" placeholder="+">
            <small class="text-muted">
                Optional (e.g. +, ~)
            </small>
            <br>
            <small class="text-danger error-text prefix_error"></small>
        </div>

        {{-- Number --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Number <span class="text-danger">*</span></label>
            <input type="number" name="number" class="form-control"
                value="{{ old('number', $counter->number ?? '') }}"
                placeholder="50000">
            <small class="text-danger error-text number_error"></small>
        </div>

        {{-- Suffix --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Suffix</label>
            <input type="text" name="suffix" class="form-control"
                value="{{ old('suffix', $counter->suffix ?? '') }}"
                placeholder="+">
            <small class="text-muted">
                Optional (e.g. +, %, K+, M+)
            </small>
            <br>
            <small class="text-danger error-text suffix_error"></small>
        </div>

        {{-- Description --}}
        <div class="col-12 mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control"
                placeholder="Optional description...">{{ old('description', $counter->description ?? '') }}</textarea>
            <small class="text-danger error-text description_error"></small>
        </div>

        {{-- Sort Order --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" class="form-control"
                value="{{ old('sort_order', $counter->sort_order ?? 0) }}" min="0">
            <small class="text-danger error-text sort_order_error"></small>
        </div>

        {{-- Status --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select select2">
                <option value="1"
                    {{ old('status', $counter->status ?? 1) == 1 ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0"
                    {{ old('status', $counter->status ?? 1) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
            <small class="text-danger error-text status_error"></small>
        </div>
    </div>

    <hr>

    <div class="d-flex justify-content-end">
        <a href="{{ route('counters.index') }}" class="btn btn-label-secondary me-2">
            <i class="ti ti-arrow-left me-1"></i>
            Cancel
        </a>
        <button type="submit" id="submitBtn" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i>
            {{ isset($counter) ? 'Update Counter' : 'Save Counter' }}
        </button>
    </div>
</form>
