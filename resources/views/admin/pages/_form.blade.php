<div class="row">
    {{-- Left --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Page Information
                </h5>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Title --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="Enter page title" value="{{ old('title', $page->title ?? '') }}">
                        <div class="invalid-feedback title_error"></div>
                    </div>

                    {{-- Slug --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slug" class="form-control"
                            placeholder="Auto generated" value="{{ old('slug', $pages->slug ?? '') }}">
                        <div class="invalid-feedback slug_error"></div>
                    </div>

                    {{-- Page Type --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Page Type</label>
                        <select name="page_type" class="form-select select2">
                            @foreach(\App\Models\Page::PAGE_TYPES as $value => $label)
                                <option value="{{ $value }}" {{ old('page_type') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback page_type_error"></div>
                    </div>

                    {{-- Sort Order --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                            min="0" value="{{ old('sort_order', $page->sort_order ?? 0) }}">
                        <div class="invalid-feedback sort_order_error"></div>
                    </div>

                    {{-- Short Description --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" rows="3" class="form-control"
                            placeholder="Short description...">{{ old('short_description', $page->short_description ?? '') }}</textarea>
                        <div class="invalid-feedback short_description_error"></div>
                    </div>

                    {{-- Description --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span> </label>
                        <textarea name="description" id="description" rows="10"
                            class="form-control">{{ old('description', $page->description ?? '') }}</textarea>
                        <div class="invalid-feedback description_error"></div>
                    </div>

                    {{-- Images --}}
                    <div class="col-12">
                        <div class="card border shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="ti ti-photo me-2"></i>
                                    Page Images
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    {{-- Featured Image --}}
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-semibold">Featured Image</label>
                                        <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                                        <div class="invalid-feedback featured_image_error"></div>
                                        <small class="text-muted">Recommended: 1600 x 900 px</small>
                                        <div class="mt-3">
                                            <img id="featuredPreview" src="{{ isset($page) ? $page->image : asset('admin/assets/img/placeholder.jpg') }}"
                                                class="img-fluid rounded border" style="height:220px;width:100%;object-fit:cover;">
                                        </div>
                                    </div>

                                    {{-- Thumbnail Image --}}
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-semibold">Thumbnail Image</label>
                                        <input type="file" name="thumbnail_image" id="thumbnail_image" class="form-control" accept="image/*">
                                        <div class="invalid-feedback thumbnail_image_error"></div>
                                        <small class="text-muted">Recommended: 600 x 600 px</small>
                                        <div class="mt-3">
                                            <img id="thumbnailPreview" src="{{ isset($page) ? asset('images/pages/'.$page->thumbnail_image) : asset('admin/assets/img/placeholder.jpg') }}"
                                                class="img-fluid rounded border" style="height:220px;width:100%;object-fit:cover;">
                                        </div>
                                    </div>

                                    {{-- Gallery Images --}}
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Gallery Images</label>
                                        <input type="file" name="images[]" id="gallery_images" class="form-control"
                                            accept="image/*" multiple>
                                        <div class="invalid-feedback images_error"></div>
                                        <small class="text-muted">
                                            You can upload multiple images.
                                        </small>
                                        <div id="galleryPreview" class="row mt-3 g-3">
                                            @if(isset($page) && $page->images->count())
                                                @foreach($page->images as $image)
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <img src="{{ asset('images/pages/gallery/'.$image->image) }}"
                                                                class="card-img-top rounded" style="height:170px;object-fit:cover;">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Meta Title --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control"
                            value="{{ old('meta_title', $page->meta_title ?? '') }}" placeholder="Meta title">
                        <div class="invalid-feedback meta_title_error"></div>
                    </div>

                    {{-- Meta Keywords --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control"
                            value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}" placeholder="travel, dubai, tour, holiday">
                        <small class="text-muted">
                            Separate keywords with commas.
                        </small>
                        <div class="invalid-feedback meta_keywords_error"></div>
                    </div>

                    {{-- Meta Description --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Meta Description </label>
                        <textarea name="meta_description" rows="4" class="form-control"
                            placeholder="Meta description...">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                        <div class="invalid-feedback meta_description_error"></div>
                    </div>

                    {{-- Featured --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block">Featured</label>
                        <label class="switch switch-warning">
                            <input type="hidden" name="featured" value="0">
                            <input type="checkbox" name="featured" value="1"
                                class="switch-input" {{ old('featured', $page->featured ?? 1) ? 'checked' : '' }}>
                            <span class="switch-toggle-slider">
                                <span class="switch-on">
                                    <i class="ti ti-check"></i>
                                </span>
                                <span class="switch-off">
                                    <i class="ti ti-x"></i>
                                </span>
                            </span>
                            <span class="switch-label">
                                Featured Page
                            </span>
                        </label>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block">Status</label>
                        <label class="switch switch-success">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" value="1"
                                class="switch-input" {{ old('status', $page->status ?? 1) ? 'checked' : '' }}>
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
                </div>
            </div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Publish
                </h5>
            </div>

            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" id="submitBtn" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>
                        {{ isset($page) && !empty($page) ? 'Update Page' : 'Save Page' }}
                    </button>
                    <a href="{{ route('pages.index') }}" class="btn btn-label-secondary">
                        <i class="ti ti-arrow-left me-1"></i>
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
