@extends('admin.layouts.app')

@section('title', 'View Blog Category')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Blog Category Details
            </h4>

            <p class="text-muted mb-0">
                View complete information about this blog category.
            </p>
        </div>

        <a href="{{ route('blog_categories.index') }}"
            class="btn btn-label-secondary">

            <i class="ti ti-arrow-left me-1"></i>

            Back

        </a>

    </div>

    <div class="row">

        {{-- Category Information --}}
        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="card-title mb-0">
                        Category Information
                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tbody>

                            <tr>
                                <th width="220">Category Name</th>
                                <td>{{ $blogCategory->name }}</td>
                            </tr>

                            <tr>
                                <th>Slug</th>
                                <td>
                                    <code>{{ $blogCategory->slug }}</code>
                                </td>
                            </tr>

                            <tr>
                                <th>Description</th>

                                <td>
                                    {!! $blogCategory->description ?: '<span class="text-muted">N/A</span>' !!}
                                </td>
                            </tr>

                            <tr>
                                <th>Sort Order</th>

                                <td>
                                    <span class="badge bg-label-primary">
                                        {{ $blogCategory->sort_order }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>

                                <td>

                                    @if($blogCategory->status)

                                        <span class="badge bg-label-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-label-danger">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        </tbody>

                    </table>

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

                    <table class="table table-borderless">

                        <tbody>

                            <tr>

                                <th width="220">
                                    Meta Title
                                </th>

                                <td>

                                    {{ $blogCategory->meta_title ?: 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Meta Description
                                </th>

                                <td>

                                    {{ $blogCategory->meta_description ?: 'N/A' }}

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">

                    <h5 class="card-title mb-0">

                        Record Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tbody>

                            <tr>

                                <th>ID</th>

                                <td>#{{ $blogCategory->id }}</td>

                            </tr>

                            <tr>

                                <th>Created At</th>

                                <td>

                                    {{ $blogCategory->created_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                            <tr>

                                <th>Updated At</th>

                                <td>

                                    {{ $blogCategory->updated_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        </tbody>

                    </table>

                    <hr>

                    <div class="d-grid gap-2">

                        @can('blog-category-edit')
                        <a href="{{ route('blog_categories.edit', $blogCategory->id) }}"
                            class="btn btn-warning">

                            <i class="ti ti-edit me-1"></i>

                            Edit Category

                        </a>
                        @endcan

                        <a href="{{ route('blog_categories.index') }}"
                            class="btn btn-label-secondary">

                            <i class="ti ti-arrow-left me-1"></i>

                            Back to List

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
