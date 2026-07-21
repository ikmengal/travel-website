@extends('admin.layouts.app')
@section('title', 'Edit Blog Tag')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Edit Blog Tag
            </h4>
            <p class="text-muted mb-0">
                Update blog tag information.
            </p>
        </div>
        <a href="{{ route('blog_tags.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>

    <form id="blogTagForm" action="{{ route('blog_tags.update', $blogTag->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Left Side --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Tag Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Tag Name --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tag Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $blogTag->name) }}" placeholder="Enter tag name">
                                <div class="invalid-feedback name_error"></div>
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="slug" class="form-control"
                                    value="{{ old('slug', $blogTag->slug) }}" placeholder="Enter slug">
                                <div class="invalid-feedback slug_error"></div>
                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" min="0" name="sort_order" class="form-control"
                                    value="{{ old('sort_order', $blogTag->sort_order) }}">
                                <div class="invalid-feedback sort_order_error"></div>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Status</label>
                                <label class="switch switch-success">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" name="status" value="1"
                                        class="switch-input" {{ old('status', $blogTag->status) ? 'checked' : '' }}>
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
                                <div class="invalid-feedback status_error"></div>
                            </div>

                            {{-- Meta Title --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control"
                                    value="{{ old('meta_title', $blogTag->meta_title) }}"
                                    placeholder="Enter meta title">
                                <div class="invalid-feedback meta_title_error"></div>
                            </div>

                            {{-- Meta Description --}}
                            <div class="col-12">
                                <label class="form-label">Meta Description </label>
                                <textarea name="meta_description" rows="5" class="form-control"
                                    placeholder="Enter meta description">{{ old('meta_description', $blogTag->meta_description) }}</textarea>
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
                            <button type="submit" id="submitBtn" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Update Tag
                            </button>

                            <a href="{{ route('blog_tags.index') }}" class="btn btn-label-secondary">
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
    @include('admin.blog_tags.partials.create_edit_scripts')
@endpush
