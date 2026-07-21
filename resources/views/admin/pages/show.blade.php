@extends('admin.layouts.app')

@section('title', 'Page Details')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                Page Details

            </h4>

            <p class="text-muted mb-0">

                View complete page information.

            </p>

        </div>

        <div>

            @can('pages-edit')

                <a href="{{ route('pages.edit', $page->id) }}"
                    class="btn btn-primary">

                    <i class="ti ti-edit me-1"></i>

                    Edit

                </a>

            @endcan

            <a href="{{ route('pages.index') }}"
                class="btn btn-label-secondary">

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

                    <h5 class="mb-0">

                        Basic Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>

                            <th width="180">

                                Title

                            </th>

                            <td>

                                {{ $page->title }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Slug

                            </th>

                            <td>

                                {{ $page->slug }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Page Type

                            </th>

                            <td>

                                <span class="badge bg-label-info">

                                    {{ \App\Models\Page::PAGE_TYPES[$page->page_type] }}

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Sort Order

                            </th>

                            <td>

                                {{ $page->sort_order }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Featured

                            </th>

                            <td>

                                @if($page->featured)

                                    <span class="badge bg-success">

                                        Yes

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Status

                            </th>

                            <td>

                                @if($page->status)

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">

                        Description

                    </h5>

                </div>

                <div class="card-body">

                    {!! $page->description !!}

                </div>

            </div>

        </div>

                {{-- Right Sidebar --}}
        <div class="col-lg-4">

            {{-- Featured Image --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Featured Image

                    </h5>

                </div>

                <div class="card-body text-center">

                    @if($page->featured_image)

                        <img
                            src="{{ asset('images/pages/' . $page->featured_image) }}"
                            alt="{{ $page->title }}"
                            class="img-fluid rounded border shadow-sm">

                    @else

                        <img
                            src="{{ asset('admin/assets/img/placeholder.jpg') }}"
                            alt="No Image"
                            class="img-fluid rounded border">

                    @endif

                </div>

            </div>

            {{-- Short Description --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Short Description

                    </h5>

                </div>

                <div class="card-body">

                    @if($page->short_description)

                        {!! nl2br(e($page->short_description)) !!}

                    @else

                        <span class="text-muted">

                            No short description available.

                        </span>

                    @endif

                </div>

            </div>

            {{-- SEO Information --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        SEO Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="120">

                                Meta Title

                            </th>

                            <td>

                                {{ $page->meta_title ?: '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Keywords

                            </th>

                            <td>

                                {{ $page->meta_keywords ?: '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Description

                            </th>

                            <td>

                                {{ $page->meta_description ?: '-' }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            {{-- Information --}}
            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">

                        Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="120">

                                Created

                            </th>

                            <td>

                                {{ $page->created_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Updated

                            </th>

                            <td>

                                {{ $page->updated_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
