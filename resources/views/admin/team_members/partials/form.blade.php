<div class="row">
    {{-- Image --}}
    <div class="col-md-4 mb-4">
        <label class="form-label">Profile Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
        <small class="text-muted">
            JPG, JPEG, PNG, WEBP (Max: 2MB)
        </small>
        <small class="text-danger error-text image_error"></small>
        <div class="mt-3">
            <img id="imagePreview" class="rounded border"
                src="{{ isset($teamMember) ? $teamMember->image : asset('admin/assets/img/avatars/1.png') }}"
                style="width:180px;height:180px;object-fit:cover;">
        </div>
    </div>

    <div class="col-md-8">
        <div class="row">
            {{-- Name --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $teamMember->name ?? '') }}"
                    placeholder="Muhammad Ali">
                <small class="text-danger error-text name_error"></small>
            </div>

            {{-- Slug --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Slug <span class="text-danger">*</span></label>
                <input type="text" id="slug" name="slug" class="form-control"
                    value="{{ old('slug', $teamMember->slug ?? '') }}"
                    placeholder="muhammad-ali">
                <small class="text-danger error-text slug_error"></small>
            </div>

            {{-- Designation --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Designation<span class="text-danger">*</span></label>
                <input type="text" name="designation" class="form-control"
                    value="{{ old('designation', $teamMember->designation ?? '') }}"
                    placeholder="Tour Manager">
                <small class="text-danger error-text designation_error"></small>
            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $teamMember->email ?? '') }}"
                    placeholder="example@email.com">
                <small class="text-danger error-text email_error"></small>
            </div>

            {{-- Phone --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                    value="{{ old('phone', $teamMember->phone ?? '') }}"
                    placeholder="+92 300 1234567">
                <small class="text-danger error-text phone_error"></small>
            </div>

            {{-- Sort Order --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control"
                    value="{{ old('sort_order', $teamMember->sort_order ?? 0) }}">
                <small class="text-danger error-text sort_order_error"></small>
            </div>
        </div>
    </div>

    {{-- Short Bio --}}
    <div class="col-12 mb-3">
        <label class="form-label">Short Bio</label>
        <textarea name="short_bio" rows="5" class="form-control"
            placeholder="Short introduction...">{{ old('short_bio', $teamMember->short_bio ?? '') }}</textarea>
        <small class="text-danger error-text short_bio_error"></small>
    </div>

    <div class="col-12">
        <hr>
        <h5 class="mb-3">
            Social Media Links
        </h5>
    </div>

    {{-- Facebook --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Facebook</label>
        <input type="url" name="facebook" class="form-control"
            value="{{ old('facebook', $teamMember->facebook ?? '') }}"
            placeholder="https://facebook.com/...">
    </div>

    {{-- Instagram --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Instagram</label>
        <input type="url" name="instagram" class="form-control"
            value="{{ old('instagram', $teamMember->instagram ?? '') }}"
            placeholder="https://instagram.com/...">
    </div>

    {{-- LinkedIn --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">LinkedIn</label>
        <input type="url" name="linkedin" class="form-control"
            value="{{ old('linkedin', $teamMember->linkedin ?? '') }}"
            placeholder="https://linkedin.com/in/...">
    </div>

    {{-- Twitter --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Twitter (X)</label>
        <input type="url" name="twitter" class="form-control"
            value="{{ old('twitter', $teamMember->twitter ?? '') }}"
            placeholder="https://x.com/...">
    </div>

    {{-- YouTube --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">YouTube</label>
        <input type="url" name="youtube" class="form-control"
            value="{{ old('youtube', $teamMember->youtube ?? '') }}"
            placeholder="https://youtube.com/...">
    </div>

    {{-- Featured --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Featured</label>
        <select name="featured" class="form-select select2">
            <option value="1"
                {{ old('featured', $teamMember->featured ?? 0) == 1 ? 'selected' : '' }}>
                Yes
            </option>
            <option value="0"
                {{ old('featured', $teamMember->featured ?? 0) == 0 ? 'selected' : '' }}>
                No
            </option>
        </select>
    </div>

    {{-- Status --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select select2">
            <option value="1"
                {{ old('status', $teamMember->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>
            <option value="0"
                {{ old('status', $teamMember->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>
</div>

<hr>

<div class="d-flex justify-content-end">
    <a href="{{ route('team_members.index') }}" class="btn btn-label-secondary me-2">
        <i class="ti ti-arrow-left me-1"></i>
        Cancel
    </a>
    <button type="submit" id="submitBtn" class="btn btn-primary">
        <i class="ti ti-device-floppy me-1"></i>
        {{ isset($teamMember) ? 'Update Team Member' : 'Save Team Member' }}
    </button>
</div>
