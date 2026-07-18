@extends('admin.layouts.app')
@section('title', 'Blog Details')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                Blog Details

            </h4>

            <p class="text-muted mb-0">

                View complete blog information.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('blog-edit')
            <a href="{{ route('blogs.edit', $blog->id) }}"
                class="btn btn-warning">

                <i class="ti ti-edit me-1"></i>

                Edit

            </a>
            @endcan

            <a href="{{ route('blogs.index') }}"
                class="btn btn-label-secondary">

                <i class="ti ti-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <div class="row">

        {{-- Left Side --}}
        <div class="col-lg-8">

            {{-- Featured Image --}}
            <div class="card mb-4">

                <div class="card-body p-0">

                    <img
                        src="{{ $blog->featured_image ? asset($blog->featured_image) : asset('admin/assets/img/avatars/1.png') }}"
                        class="img-fluid rounded w-100"
                        style="max-height:450px;object-fit:cover;">

                </div>

            </div>

            {{-- Blog Content --}}
            <div class="card">

                <div class="card-header">

                    <h4 class="mb-1">

                        {{ $blog->title }}

                    </h4>

                    <small class="text-muted">

                        {{ $blog->slug }}

                    </small>

                </div>

                <div class="card-body">

                    <h6 class="fw-semibold">

                        Short Description

                    </h6>

                    <p class="text-muted">

                        {{ $blog->short_description }}

                    </p>

                    <hr>

                    <h6 class="fw-semibold">

                        Description

                    </h6>

                    <div class="blog-description">

                        {!! $blog->description !!}

                    </div>

                </div>

            </div>

        </div>

        {{-- Right Sidebar --}}
        <div class="col-lg-4">
                        {{-- Blog Information --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="card-title mb-0">

                        Blog Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tbody>

                            <tr>

                                <th width="40%">
                                    Category
                                </th>

                                <td>

                                    <span class="badge bg-label-primary">

                                        {{ $blog->category->name ?? '-' }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Author
                                </th>

                                <td>

                                    {{ $blog->author ?: '-' }}

                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Views
                                </th>

                                <td>

                                    {{ number_format($blog->views) }}

                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Publish Date
                                </th>

                                <td>

                                    {{ optional($blog->published_at)->format('d M Y h:i A') ?? '-' }}

                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Featured
                                </th>

                                <td>

                                    @if($blog->featured)

                                        <span class="badge bg-label-warning">

                                            Featured

                                        </span>

                                    @else

                                        <span class="badge bg-label-secondary">

                                            Normal

                                        </span>

                                    @endif

                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Status
                                </th>

                                <td>

                                    @if($blog->status)

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

                            <tr>

                                <th>
                                    Created At
                                </th>

                                <td>

                                    {{ $blog->created_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Updated At
                                </th>

                                <td>

                                    {{ $blog->updated_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- SEO Information --}}
            <div class="card">

                <div class="card-header">

                    <h5 class="card-title mb-0">

                        SEO Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <label class="fw-semibold d-block mb-1">

                            Meta Title

                        </label>

                        <p class="text-muted mb-0">

                            {{ $blog->meta_title ?: '-' }}

                        </p>

                    </div>

                    <hr>

                    <div>

                        <label class="fw-semibold d-block mb-1">

                            Meta Description

                        </label>

                        <p class="text-muted mb-0">

                            {{ $blog->meta_description ?: '-' }}

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
