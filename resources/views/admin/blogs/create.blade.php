@extends('admin.layouts.app')
@section('title', 'Create Blog')
@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Create Blog
            </h4>
            <p class="text-muted mb-0">
                Create a new blog article.
            </p>
        </div>
        <a href="{{ route('blogs.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>

    <form id="blogForm" action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            {{-- Left Side --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Blog Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Category --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="blog_category_id" id="blog_category_id" class="form-select select2">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger blog_category_id_error"></small>
                            </div>

                            {{-- Author --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" id="author" name="author" class="form-control"
                                    value="{{ old('author') }}" placeholder="Author Name">
                                <small class="text-danger author_error"></small>
                            </div>

                            {{-- Title --}}
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Blog Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ old('title') }}" placeholder="Enter blog title">
                                <small class="text-danger title_error"></small>
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control"
                                    value="{{ old('slug') }}" placeholder="Auto Generate">
                                <small class="text-danger slug_error"></small>
                            </div>

                            {{-- Featured Image --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">Featured Image</label>
                                <input type="file" id="featured_image" name="featured_image"
                                    class="form-control" accept=".jpg,.jpeg,.png,.webp">
                                <small class="text-danger featured_image_error"></small>
                                <div class="mt-3">
                                    <img id="imagePreview" src="{{ asset('admin/assets/img/avatars/1.png') }}"
                                        class="rounded border" style="width:160px;height:110px;object-fit:cover;">
                                </div>
                            </div>

                            {{-- Short Description --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea id="short_description" name="short_description" rows="4" maxlength="500"
                                    class="form-control" placeholder="Write a short description...">{{ old('short_description') }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-danger short_description_error"></small>
                                    <small class="text-muted">
                                        <span id="shortDescriptionCount">0</span>/500
                                    </small>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea id="description" name="description" class="form-control"
                                    rows="10">{{ old('description') }}</textarea>
                                <small class="text-danger description_error"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4">
                {{-- Publish Settings --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Publish Settings
                        </h5>
                    </div>

                    <div class="card-body">
                        {{-- Published At --}}
                        <div class="mb-3">
                            <label class="form-label">Publish Date</label>
                            <input type="datetime-local" name="published_at"
                                id="published_at" class="form-control"
                                value="{{ old('published_at') }}">
                            <small class="text-danger published_at_error"></small>
                        </div>

                        {{-- Views --}}
                        <div class="mb-3">
                            <label class="form-label">Initial Views</label>
                            <input type="number" min="0" name="views" id="views"
                                class="form-control" value="{{ old('views',0) }}">
                            <small class="text-danger views_error"></small>
                        </div>

                        {{-- Featured --}}
                        <div class="mb-4">
                            <label class="form-label d-block">Featured Blog</label>
                            <input type="hidden" name="featured" value="0">
                            <label class="switch switch-warning">
                                <input type="checkbox" class="switch-input" name="featured"
                                    value="1" {{ old('featured') ? 'checked' : '' }}>
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

                        {{-- Status --}}
                        <div>
                            <label class="form-label d-block">Status</label>
                            <input type="hidden" name="status" value="0">
                            <label class="switch switch-success">
                                <input type="checkbox" class="switch-input" name="status"
                                    value="1" {{ old('status', true) ? 'checked' : '' }}>
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
                            <input type="text" id="meta_title" name="meta_title" class="form-control"
                                maxlength="255" value="{{ old('meta_title') }}" placeholder="Enter meta title">
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
                            <textarea id="meta_description" name="meta_description" rows="5" maxlength="500"
                                class="form-control" placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-danger meta_description_error"></small>
                                <small class="text-muted">
                                    <span id="metaDescriptionCount">0</span>/500
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
                                Save Blog
                            </button>

                            <a href="{{ route('blogs.index') }}" class="btn btn-label-secondary">
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
    @include('admin.blogs.partials.create-scripts')
@endpush
