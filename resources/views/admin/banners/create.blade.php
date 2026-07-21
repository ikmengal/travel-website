@extends('admin.layouts.app')
@section('title', 'Create Banner')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                Create Banner

            </h4>

            <p class="text-muted mb-0">

                Add a new homepage banner or slider.

            </p>

        </div>

        <a href="{{ route('banners.index') }}"
            class="btn btn-label-secondary">

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

                                    Title
                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    class="form-control"
                                    value="{{ old('title') }}"
                                    placeholder="Enter banner title">

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
                                    placeholder="Enter subtitle">

                                <div class="invalid-feedback subtitle_error"></div>

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
                                    placeholder="e.g. Book Now">

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

                            {{-- Description --}}
                            <div class="col-12 mb-3">

                                <label class="form-label">

                                    Description

                                </label>

                                <textarea
                                    name="description"
                                    id="description"
                                    rows="6"
                                    class="form-control"
                                    placeholder="Enter banner description">{{ old('description') }}</textarea>

                                <div class="invalid-feedback description_error"></div>

                            </div>

                            {{-- Image --}}
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
                                        alt="Preview"
                                        class="img-fluid rounded border"
                                        style="max-height:220px; display:none;">

                                </div>

                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-6 mb-3">

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
                            <div class="col-md-3 mb-3">

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
                            <div class="col-md-3 mb-3">

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
                            <div class="col-12">

                                <label class="form-label">

                                    Meta Description

                                </label>

                                <textarea
                                    name="meta_description"
                                    rows="5"
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
        </div>
    </form>
@endsection
@push('js')
    @include('admin.banners.partials.create_edit_script')
@endpush
