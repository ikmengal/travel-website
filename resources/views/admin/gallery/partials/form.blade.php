<div class="row">
    {{-- Image --}}
    <div class="col-lg-4 mb-4">
        <label class="form-label">Gallery Image <span class="text-danger">*</span></label>
        <div class="text-center">
            <img id="imagePreview" src="{{ isset($gallery) ? $gallery->image : asset('admin/assets/img/avatars/1.png') }}"
                class="img-thumbnail mb-3" style="width:100%;max-height:250px;object-fit:cover;">
        </div>
        <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <small class="text-muted">
            Allowed: JPG, JPEG, PNG, WEBP (Max 2MB)
        </small>
        <small class="text-danger error-text image_error"></small>
    </div>

    {{-- Right --}}
    <div class="col-lg-8">
        <div class="row">
            {{-- Title --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $gallery->title ?? '') }}" placeholder="Beautiful Beach">
                <small class="text-danger error-text title_error"></small>
            </div>

            {{-- Slug --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $gallery->slug ?? '') }}" placeholder="beautiful-beach">
                <small class="text-danger error-text slug_error"></small>
            </div>

            {{-- Category --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $gallery->category ?? '') }}" placeholder="Beach">
                <small class="text-danger error-text category_error"></small>
            </div>

            {{-- Caption --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Caption</label>
                <input type="text" name="caption" class="form-control" value="{{ old('caption', $gallery->caption ?? '') }}" placeholder="Short caption">
                <small class="text-danger error-text caption_error"></small>
            </div>

            {{-- Country --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Country</label>
                <select name="country_id" class="form-select select2">
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ old('country_id', $gallery->country_id ?? '') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-danger error-text country_id_error"></small>
            </div>

            {{-- Status --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select select2">
                    <option value="1"
                        {{ old('status', $gallery->status ?? 1)==1 ? 'selected':'' }}>
                        Active
                    </option>
                    <option value="0"
                        {{ old('status', $gallery->status ?? 1)==0 ? 'selected':'' }}>
                        Inactive
                    </option>
                </select>
                <small class="text-danger error-text status_error"></small>
            </div>

            {{-- Sort --}}
            <div class="col-md-3 mb-3">
                <label class="form-label">Sort Order </label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $gallery->sort_order ?? 0) }}" min="0">
                <small class="text-danger error-text sort_order_error"></small>
            </div>

            {{-- Featured --}}
            <div class="col-md-3 mb-3">
                <label class="form-label">Featured</label>
                <select name="featured" class="form-select select2">
                    <option value="1"
                        {{ old('featured', $gallery->featured ?? 0)==1 ? 'selected':'' }}>
                        Yes
                    </option>
                    <option value="0"
                        {{ old('featured', $gallery->featured ?? 0)==0 ? 'selected':'' }}>
                        No
                    </option>
                </select>
                <small class="text-danger error-text featured_error"></small>
            </div>

            {{-- Short description --}}
            <div class="col-12 mb-3">
                <label class="form-label">Short Description</label>
                <textarea name="short_description" id="short_description" class="form-control">{{ old('short_description', $gallery->short_description ?? '') }}</textarea>
                <small class="text-danger error-text description_error"></small>
            </div>

            {{-- Description --}}
            <div class="col-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $gallery->description ?? '') }}</textarea>
                <small class="text-danger error-text description_error"></small>
            </div>
        </div>
    </div>
</div>
