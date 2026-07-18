@extends('admin.layouts.app')
@section('title', 'Edit Blog Category')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Edit Blog Category
            </h4>
            <p class="text-muted mb-0">
                Update blog category information.
            </p>
        </div>

        <a href="{{ route('blog_categories.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>

    <form id="blogCategoryForm" action="{{ route('blog_categories.update', $blogCategory->id) }}" method="POST">
        @csrf
        @method('PUT')

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
                            {{-- Category Name --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="{{ old('name', $blogCategory->name) }}"
                                    placeholder="Enter category name">
                                <small class="text-danger name_error"></small>
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label"> Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control"
                                    value="{{ old('slug', $blogCategory->slug) }}"
                                    placeholder="Auto Generate">
                                <small class="text-danger slug_error"></small>
                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" min="0"
                                    class="form-control" value="{{ old('sort_order', $blogCategory->sort_order) }}">
                                <small class="text-danger sort_order_error"></small>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control ckeditor"
                                    rows="8">{{ old('description', $blogCategory->description) }}</textarea>
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
                            <input type="checkbox" class="switch-input" name="status" value="1"
                                {{ old('status', $blogCategory->status) ? 'checked' : '' }}>
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

                {{-- SEO Information --}}
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
                            <input type="text" id="meta_title" name="meta_title"
                                class="form-control" maxlength="255" value="{{ old('meta_title', $blogCategory->meta_title) }}"
                                placeholder="Meta Title">
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-danger meta_title_error"></small>
                                <small class="text-muted">
                                    <span id="metaTitleCount">
                                        {{ strlen(old('meta_title', $blogCategory->meta_title ?? '')) }}
                                    </span>/255
                                </small>
                            </div>
                        </div>

                        {{-- Meta Description --}}
                        <div class="mb-0">
                            <label class="form-label">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="5"
                                maxlength="500" class="form-control"
                                placeholder="Meta Description">{{ old('meta_description', $blogCategory->meta_description) }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-danger meta_description_error"></small>
                                <small class="text-muted">
                                    <span id="metaDescriptionCount">
                                        {{ strlen(old('meta_description', $blogCategory->meta_description ?? '')) }}
                                    </span>/500
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Card --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" id="submitBtn" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Update Category
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
