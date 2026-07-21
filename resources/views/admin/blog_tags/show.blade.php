@extends('admin.layouts.app')
@section('title', 'View Blog Tag')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Blog Tag Details</h4>
            <p class="text-muted mb-0">
                View complete information about this blog tag.
            </p>
        </div>

        <div>
            @can('blog-tags-edit')
                <a href="{{ route('blog_tags.edit', $blogTag->id) }}" class="btn btn-warning me-2">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan
            <a href="{{ route('blog_tags.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Left --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Tag Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="220">Tag Name</th>
                                    <td>{{ $blogTag->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td><code>{{ $blogTag->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($blogTag->status)
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order</th>
                                    <td>{{ $blogTag->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Blogs Using This Tag</th>
                                    <td>
                                        <span class="badge bg-label-primary">
                                            {{ $blogTag->blogs()->count() }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        SEO Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <label class="fw-semibold">Meta Title</label>
                        <p class="text-muted mb-0">
                            {{ $blogTag->meta_title ?: 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="fw-semibold">Meta Description</label>
                        <p class="text-muted mb-0">
                            {{ $blogTag->meta_description ?: 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <label class="fw-semibold d-block">Created At</label>
                        <span class="text-muted">
                            {{ $blogTag->created_at->format('d M Y h:i A') }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold d-block">Last Updated</label>
                        <span class="text-muted">
                            {{ $blogTag->updated_at->format('d M Y h:i A') }}
                        </span>
                    </div>
                    <div>
                        <label class="fw-semibold d-block">Deleted At</label>
                        <span class="text-muted">
                            {{ $blogTag->deleted_at ? $blogTag->deleted_at->format('d M Y h:i A') : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
