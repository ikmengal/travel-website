{{-- Basic Information --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-user-star me-2 text-primary"></i>
            Basic Information
        </h5>
    </div>

    <div class="card-body">
        <div class="row">
            {{-- Image --}}
            <div class="col-lg-3 text-center mb-4">
                @php
                    $image = old('image_preview');
                    if (isset($testimonial) && $testimonial->image) {
                        $image = asset('images/testimonials/'.$testimonial->image);
                    }
                @endphp

                <img id="imagePreview"
                    src="{{ $image ?: asset('admin/assets/img/avatars/1.png') }}"
                    class="rounded border shadow-sm mb-3" width="170" height="170"
                    style="object-fit:cover;">
                <div class="mb-2">
                    <input type="file" class="form-control" id="image"
                        name="image" accept="image/*">
                    <span class="text-danger image_error"></span>
                </div>
                <small class="text-muted">
                    JPG, PNG, JPEG (Max: 2MB)
                </small>
            </div>

            {{-- Details --}}
            <div class="col-lg-9">
                <div class="row">
                    {{-- Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name"
                            value="{{ old('name', $testimonial->name ?? '') }}">
                        <span class="text-danger name_error"></span>
                    </div>

                    {{-- Designation --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Designation <span class="text-danger">*</span></label>
                        <input type="text" name="designation" class="form-control" placeholder="CEO, Manager etc."
                            value="{{ old('designation', $testimonial->designation ?? '') }}">
                        <span class="text-danger designation_error"></span>
                    </div>

                    {{-- Company --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" name="company" class="form-control" placeholder="Company Name"
                            value="{{ old('company', $testimonial->company ?? '') }}">
                        <span class="text-danger company_error"></span>
                    </div>

                    {{-- Rating --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <select name="rating" id="rating" class="form-select select2">
                            <option value="">Select Rating</option>
                            @for($i=5;$i>=1;$i--)
                                <option value="{{ $i }}" {{ old('rating',$testimonial->rating ?? '') == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                        <span class="text-danger rating_error"></span>
                    </div>

                    {{-- Country --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <select name="country_id" id="country_id" class="form-select select2">
                            <option value="">Select Country</option>
                            @foreach($countries as $key => $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $country->id ?? '') }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger country_id_error"></span>
                    </div>

                    {{-- State --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">State <span class="text-danger">*</span></label>
                        <select name="state_id" id="state_id" class="form-select select2">
                            <option value="">Select State</option>
                        </select>
                        <span class="text-danger state_id_error"></span>
                    </div>

                    {{-- City --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <select name="city_id" id="city_id" class="form-select select2">
                            <option value="">Select City</option>
                        </select>
                        <span class="text-danger city_id_error"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Review & Settings --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-message-2-star me-2 text-warning"></i>
            Review & Settings
        </h5>
    </div>

    <div class="card-body">
        <div class="row">
            {{---------------Review---------------}}
            <div class="col-12 mb-4">
                <label class="form-label">Customer Review <span class="text-danger">*</span></label>
                <textarea name="review" id="review" rows="8" class="form-control"
                    placeholder="Write testimonial review...">{!! old('review', $testimonial->review ?? '') !!}</textarea>
                <span class="text-danger review_error"></span>
            </div>

            {{---------------Featured---------------}}
            <div class="col-md-4 mb-3">
                <input type="hidden" name="featured" value="0">
                <label class="form-label d-block">Featured Testimonial</label>
                <label class="switch switch-warning">
                    <input type="checkbox" name="featured" value="1" class="switch-input"
                        {{ old('featured', $testimonial->featured ?? false) ? 'checked' : '' }}>
                    <span class="switch-toggle-slider">
                        <span class="switch-on">
                            <i class="ti ti-star-filled"></i>
                        </span>
                        <span class="switch-off">
                            <i class="ti ti-star"></i>
                        </span>
                    </span>
                    <span class="switch-label">
                        Featured
                    </span>
                </label>
            </div>

            {{---------------Status---------------}}
            <div class="col-md-4 mb-3">
                <input type="hidden" name="status" value="0">
                <label class="form-label d-block">Status</label>
                <label class="switch switch-success">
                    <input type="checkbox" name="status" value="1"
                        class="switch-input" {{ old('status', isset($testimonial) ? $testimonial->status : true) ? 'checked' : '' }}>
                    <span class="switch-toggle-slider">
                        <span class="switch-on">
                            <i class="ti ti-check"></i>
                        </span>
                        <span class="switch-off">
                            <i class="ti ti-x"></i>
                        </span>
                    </span>
                    <span class="switch-label">
                        Active
                    </span>
                </label>
            </div>

            {{---------------Sort Order---------------}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Sort Order </label>
                <input type="number" min="0" name="sort_order" class="form-control"
                    placeholder="0" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
                <span class="text-danger sort_order_error"></span>
            </div>
        </div>
    </div>
</div>

{{---------------SEO Information---------------}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-seo me-2 text-info"></i>
            SEO Information
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            {{---------------Meta Title---------------}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control" maxlength="255"
                    placeholder="Enter Meta Title"
                    value="{{ old('meta_title', $testimonial->meta_title ?? '') }}">
                <small class="text-muted">
                    Recommended: 50 - 60 characters
                </small>
                <span class="text-danger meta_title_error"></span>
            </div>

            {{---------------Meta Description---------------}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" rows="4" maxlength="500" class="form-control"
                    placeholder="Enter Meta Description">{{ old('meta_description', $testimonial->meta_description ?? '') }}</textarea>
                <small class="text-muted">
                    Recommended: 150 - 160 characters
                </small>
                <span class="text-danger meta_description_error"></span>
            </div>
        </div>
    </div>

    {{---------------Action Buttons---------------}}
    <div class="card-body">
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('testimonials.index') }}"class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>

            <button type="reset" class="btn btn-label-warning">
                <i class="ti ti-refresh me-1"></i>
                Reset
            </button>

            <button type="submit" id="submitBtn" class="btn btn-primary">
                <i class="ti ti-device-floppy me-1"></i>
                {{ isset($testimonial) ? 'Update Testimonial' : 'Save Testimonial' }}
            </button>
        </div>
    </div>
</div>
