@extends('admin.layouts.app')
@section('title', 'Create Blog Category')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Create Blog Category
            </h4>
            <p class="text-muted mb-0">
                Add a new blog category.
            </p>
        </div>

        <a href="{{ route('blog_categories.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>

    <form id="blogCategoryForm" action="{{ route('blog_categories.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- Left Side --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Category Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Enter category name">
                                <small class="text-danger name_error"></small>
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    value="{{ old('slug') }}" placeholder="Auto Generate">
                                <small class="text-danger slug_error"></small>
                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order"
                                    min="0" value="{{ old('sort_order',0) }}">
                                <small class="text-danger sort_order_error"></small>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea id="description" name="description" rows="8"
                                    class="form-control ckeditor">{{ old('description') }}</textarea>
                                <small class="text-danger description_error"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side --}}
            <div class="col-lg-4">
                {{-- Publish --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Publish
                        </h5>
                    </div>

                    <div class="card-body">
                        <input type="hidden" name="status" value="0">
                        <label class="switch switch-success">
                            <input type="checkbox" class="switch-input" name="status" value="1" checked>
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

                {{-- SEO --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            SEO Information
                        </h5>
                    </div>

                    <div class="card-body">
                        {{-- Meta Title --}}
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title"
                                name="meta_title" maxlength="255" value="{{ old('meta_title') }}"
                                placeholder="Meta title">
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-danger meta_title_error"></small>
                                <small class="text-muted">
                                    <span id="metaTitleCount">0</span>/255
                                </small>
                            </div>
                        </div>

                        {{-- Meta Description --}}
                        <div>
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description"
                                rows="5" maxlength="500" placeholder="Meta description">{{ old('meta_description') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-danger meta_description_error"></small>
                                <small class="text-muted">
                                    <span id="metaDescriptionCount">0</span>/500
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save Category
                            </button>

                            <a href="{{ route('blog_categories.index') }}" class="btn btn-label-secondary">
                                <i class="ti ti-arrow-left me-1"></i>
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
    @include('admin.blog_categories.partials.create-script')
@endpush
