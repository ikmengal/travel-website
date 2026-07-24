@extends('admin.layouts.app')

@section('title', 'Create Banner')

@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create Banner</h4>
            <p class="text-muted mb-0">
                Add a new homepage banner or slider.
            </p>
        </div>

        <a href="{{ route('banners.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>

    <form id="bannerForm"
          action="{{ route('banners.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="row">

            {{-- Left Side --}}
            <div class="col-lg-8">

                <div class="card mb-4">

                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Banner Information
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Title --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Title <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    value="{{ old('title') }}"
                                    placeholder="#1 Travel Booking Platform">

                                <div class="invalid-feedback title_error"></div>
                            </div>

                            {{-- Subtitle --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Subtitle
                                </label>

                                <input
                                    type="text"
                                    name="subtitle"
                                    class="form-control"
                                    value="{{ old('subtitle') }}"
                                    placeholder="Discover Amazing">

                                <div class="invalid-feedback subtitle_error"></div>
                            </div>

                            {{-- Subtitle One --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Subtitle One
                                </label>

                                <input
                                    type="text"
                                    name="subtitle_1"
                                    class="form-control"
                                    value="{{ old('subtitle_1') }}"
                                    placeholder="Places Around">

                                <div class="invalid-feedback subtitle_1_error"></div>
                            </div>

                            {{-- Subtitle Two --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Subtitle Two
                                </label>

                                <input
                                    type="text"
                                    name="subtitle_2"
                                    class="form-control"
                                    value="{{ old('subtitle_2') }}"
                                    placeholder="The World">

                                <div class="invalid-feedback subtitle_2_error"></div>
                            </div>

                            {{-- Subtitle Three --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Subtitle Three
                                </label>

                                <input
                                    type="text"
                                    name="subtitle_3"
                                    class="form-control"
                                    value="{{ old('subtitle_3') }}"
                                    placeholder="Explore">

                                <div class="invalid-feedback subtitle_3_error"></div>
                            </div>

                            {{-- Button Text --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Button Text
                                </label>

                                <input
                                    type="text"
                                    name="button_text"
                                    class="form-control"
                                    value="{{ old('button_text') }}"
                                    placeholder="Book Now">

                                <div class="invalid-feedback button_text_error"></div>
                            </div>

                            {{-- Button URL --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Button URL
                                </label>

                                <input
                                    type="url"
                                    name="button_url"
                                    class="form-control"
                                    value="{{ old('button_url') }}"
                                    placeholder="https://example.com">

                                <div class="invalid-feedback button_url_error"></div>
                            </div>

                            {{-- Avatars Data --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Avatars Data
                                </label>

                                <input
                                    type="text"
                                    name="avatars_data"
                                    class="form-control"
                                    value="{{ old('avatars_data') }}"
                                    placeholder="50K+ Happy Travelers">

                                <div class="invalid-feedback avatars_data_error"></div>
                            </div>

                            {{-- Card Location --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Card Location
                                </label>

                                <input
                                    type="text"
                                    name="card_location"
                                    class="form-control"
                                    value="{{ old('card_location') }}"
                                    placeholder="Bali, Indonesia">

                                <div class="invalid-feedback card_location_error"></div>
                            </div>

                            {{-- Card Paragraph --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Card Paragraph
                                </label>

                                <input
                                    type="text"
                                    name="card_para"
                                    class="form-control"
                                    value="{{ old('card_para') }}"
                                    placeholder="French Polynesia">

                                <div class="invalid-feedback card_para_error"></div>
                            </div>

                            {{-- Card Reviews --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Card Reviews
                                </label>

                                <input
                                    type="text"
                                    name="card_reviews"
                                    class="form-control"
                                    value="{{ old('card_reviews') }}"
                                    placeholder="4.9 (220 Reviews)">

                                <div class="invalid-feedback card_reviews_error"></div>
                            </div>

                                                        {{-- Description --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    rows="5"
                                    class="form-control"
                                    placeholder="Enter banner description">{{ old('description') }}</textarea>

                                <div class="invalid-feedback description_error"></div>
                            </div>

                            {{-- Tag Icon --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Tag Icon
                                </label>

                                <input
                                    type="text"
                                    name="tag_icon"
                                    class="form-control"
                                    value="{{ old('tag_icon') }}"
                                    placeholder="ti ti-send">

                                <div class="invalid-feedback tag_icon_error"></div>
                            </div>

                            {{-- Tag Heading --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Tag Heading
                                </label>

                                <input
                                    type="text"
                                    name="tag_heading"
                                    class="form-control"
                                    value="{{ old('tag_heading') }}"
                                    placeholder="Best Price Guarantee">

                                <div class="invalid-feedback tag_heading_error"></div>
                            </div>

                            {{-- Tag Description --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Tag Description
                                </label>

                                <textarea
                                    name="tag_para"
                                    rows="4"
                                    class="form-control"
                                    placeholder="We ensure best price for your trips">{{ old('tag_para') }}</textarea>

                                <div class="invalid-feedback tag_para_error"></div>
                            </div>

                            {{-- Banner Image --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Banner Image
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    class="form-control"
                                    accept="image/*">

                                <div class="invalid-feedback image_error"></div>

                                <div class="mt-3">
                                    <img
                                        id="imagePreview"
                                        src="{{ asset('admin/assets/img/placeholder.jpg') }}"
                                        class="img-fluid rounded border"
                                        style="display:none;max-height:220px;"
                                        alt="Preview">
                                </div>
                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Sort Order
                                </label>

                                <input
                                    type="number"
                                    name="sort_order"
                                    class="form-control"
                                    value="{{ old('sort_order',0) }}"
                                    min="0">

                                <div class="invalid-feedback sort_order_error"></div>
                            </div>

                            {{-- Featured --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label d-block">
                                    Featured
                                </label>

                                <label class="switch switch-warning">

                                    <input
                                        type="hidden"
                                        name="featured"
                                        value="0">

                                    <input
                                        type="checkbox"
                                        name="featured"
                                        value="1"
                                        class="switch-input"
                                        {{ old('featured') ? 'checked' : '' }}>

                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>

                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>

                                    <span class="switch-label">
                                        Yes
                                    </span>

                                </label>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label d-block">
                                    Status
                                </label>

                                <label class="switch switch-success">

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="0">

                                    <input
                                        type="checkbox"
                                        name="status"
                                        value="1"
                                        class="switch-input"
                                        {{ old('status',1) ? 'checked' : '' }}>

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

                                                        {{-- Meta Title --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Meta Title
                                </label>

                                <input
                                    type="text"
                                    name="meta_title"
                                    class="form-control"
                                    value="{{ old('meta_title') }}"
                                    placeholder="Enter meta title">

                                <div class="invalid-feedback meta_title_error"></div>
                            </div>

                            {{-- Meta Description --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Meta Description
                                </label>

                                <textarea
                                    name="meta_description"
                                    rows="4"
                                    class="form-control"
                                    placeholder="Enter meta description">{{ old('meta_description') }}</textarea>

                                <div class="invalid-feedback meta_description_error"></div>
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

                            <button
                                type="submit"
                                id="submitBtn"
                                class="btn btn-primary">

                                <i class="ti ti-device-floppy me-1"></i>
                                Save Banner

                            </button>

                            <a
                                href="{{ route('banners.index') }}"
                                class="btn btn-label-secondary">

                                <i class="ti ti-x me-1"></i>
                                Cancel

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection

@push('js')
    @include('admin.banners.partials.create_edit_script')
@endpush
