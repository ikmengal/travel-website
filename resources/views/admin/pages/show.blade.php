@extends('admin.layouts.app')
@section('title', 'Page Details')
@push('css')
    <style>
        .table>tbody>tr>th{
            width:180px;
            font-weight:600;
            color:#566a7f;
        }

        .table>tbody>tr>td{
            color:#697a8d;
        }

        .card{
            border:none;
            box-shadow:0 .125rem .375rem rgba(34,48,62,.08);
        }

        .card-header{
            background:#fff;
            border-bottom:1px solid #ebeef0;
        }

        .gallery-card{
            transition:.35s;
        }

        .gallery-card:hover{
            transform:translateY(-6px);
        }

        .gallery-card img{
            transition:.35s;
        }

        .gallery-card:hover img{
            transform:scale(1.04);
        }

        .page-image{
            width:100%;
            height:420px;
            object-fit:cover;
            border-radius:12px;
        }

        .thumbnail-image{
            width:100%;
            height:220px;
            object-fit:cover;
            border-radius:12px;
        }

        .gallery-image{
            width:100%;
            height:200px;
            object-fit:cover;
            border-radius:10px;
        }

        .badge{
            font-size:12px;
        }
    </style>
@endpush
@section('content')
    {{-- Header --}}
    {{-- <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                {{ $page->title }}
            </h3>

            <p class="text-muted mb-0">
                Complete page information with SEO, images and gallery.
            </p>
        </div>

        <div class="d-flex gap-2">
            @can('pages-edit')
                <a href="{{ route('pages.edit',$page->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit Page
                </a>
            @endcan

            <a href="{{ route('pages.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div> --}}

    {{-- Hero Banner --}}
    <div class="card overflow-hidden border-0 shadow-sm mb-4">
        <div class="position-relative">
            <img src="{{ isset($page->thumbnail_image) && !empty($page->thumbnail_image) ? asset('images/pages/'.$page->thumbnail_image) : $page->image }}" class="w-100" style="height:320px;object-fit:cover;" alt="{{ $page->title }}">

            <div class="position-absolute top-0 start-0 w-100 h-100"
                style="background:linear-gradient(to top,rgba(0,0,0,.85),rgba(0,0,0,.15));">
            </div>

            <div class="position-absolute bottom-0 start-0 p-5 text-white w-100">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <span class="badge bg-primary mb-3 px-3 py-2">
                            {{ $page->page_type }}
                        </span>

                        <h2 class="fw-bold text-white mb-2">
                            {{ $page->title }}
                        </h2>

                        <p class="mb-3 opacity-75">
                            {{ $page->short_description }}
                        </p>

                        <div class="d-flex gap-2 flex-wrap">
                            @if($page->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif

                            @if($page->featured)
                                <span class="badge bg-warning text-dark">Featured</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex">
                        @can('pages-edit')
                            <a href="{{ route('pages.edit',$page->id) }}" class="btn btn-primary mx-1">
                                <i class="ti ti-edit me-1"></i>
                                Edit
                            </a>
                        @endcan
                        <a href="{{ route('pages.index') }}" class="btn btn-light">
                            <i class="ti ti-arrow-left me-1"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- LEFT SIDE --}}
        <div class="col-lg-8">
            {{-- BASIC INFORMATION CARD --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Basic Information
                    </h5>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <tbody>
                            <tr>
                                <th width="220">Title</th>
                                <td>{{ $page->title }}</td>
                            </tr>

                            <tr>
                                <th>Slug</th>
                                <td>
                                    <code>{{ $page->slug }}</code>
                                </td>
                            </tr>

                            <tr>
                                <th>Page Type</th>
                                <td>
                                    <span class="badge bg-label-primary">
                                        {{ \App\Models\Page::PAGE_TYPES[$page->page_type] }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Sort Order</th>
                                <td>{{ $page->sort_order }}</td>
                            </tr>

                            <tr>
                                <th>Featured</th>
                                <td>
                                    @if($page->featured)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($page->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Created At</th>
                                <td>{{ $page->created_at->format('d M Y h:i A') }}</td>
                            </tr>

                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $page->updated_at->format('d M Y h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SHORT DESCRIPTION --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Short Description
                    </h5>
                </div>

                <div class="card-body">
                    @if($page->short_description)
                        {!! nl2br(e($page->short_description)) !!}
                    @else
                        <div class="alert alert-warning mb-0">
                            No short description available.
                        </div>
                    @endif
                </div>
            </div>

            {{-- PAGE DESCRIPTION --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Full Description
                    </h5>
                </div>

                <div class="card-body">{!! $page->description !!}</div>
            </div>

            {{-- FEATURED IMAGE --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Featured Image
                    </h5>

                    @if($page->featured)
                        <span class="badge bg-success">Featured</span>
                    @endif
                </div>

                <div class="card-body text-center">
                    <img src="{{ $page->image }}" alt="{{ $page->title }}" class="img-fluid rounded-4 shadow border" style="width:100%;max-height:450px;object-fit:cover;">
                </div>
            </div>
        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="col-lg-4">
            {{-- SEO INFORMATION --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        SEO Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Meta Title</label>
                        <div class="border rounded p-3 bg-light">
                            {{ $page->meta_title ?: 'Not Available' }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Meta Keywords</label>
                        <div class="border rounded p-3 bg-light">
                            @if($page->meta_keywords)
                                @foreach(explode(',', $page->meta_keywords) as $keyword)
                                    <span class="badge bg-label-primary me-1 mb-1">
                                        {{ trim($keyword) }}
                                    </span
                                @endforeach
                            @else
                                <span class="text-muted">
                                    No keywords available.
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="form-label fw-semibold">Meta Description</label>
                        <div class="border rounded p-3 bg-light">
                            {{ $page->meta_description ?: 'Not Available' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- PAGE INFORMATION --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Information</h5>
                </div>

                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th width="150">Page ID</th>
                                <td>#{{ $page->id }}</td>
                            </tr>

                            <tr>
                                <th>Slug</th>
                                <td>
                                    <code>{{ $page->slug }}</code>
                                </td>
                            </tr>

                            <tr>
                                <th>Type</th>
                                <td>
                                    <span class="badge bg-label-info">
                                        {{ \App\Models\Page::PAGE_TYPES[$page->page_type] }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Sort Order</th>
                                <td>{{ $page->sort_order }}</td>
                            </tr>

                            <tr>
                                <th>Featured</th>
                                <td>
                                    @if($page->featured)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($page->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Gallery Images</th>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $page->images->count() }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Created</th>
                                <td>{{ $page->created_at->format('d M Y h:i A') }}</td>
                            </tr>

                            <tr>
                                <th>Updated</th>
                                <td>{{ $page->updated_at->format('d M Y h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- QUICK STATUS --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Status</h5>
                </div>

                <div class="card-body">
                    <div class="d-grid gap-3">
                        <div class="d-flex justify-content-between">
                            <span>Featured</span>
                            @if($page->featured)
                                <span class="badge bg-success">Enabled</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Published</span>
                            @if($page->status)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-danger">Draft</span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Gallery</span>
                            <span class="badge bg-primary">
                                {{ $page->images->count() }} Images
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
                <div class="col-lg-12">
            {{-- PAGE GALLERY --}}
            @if($page->images->count())
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Gallery Images</h5>
                        <span class="badge bg-primary">
                            {{ $page->images->count() }}
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($page->images as $image)
                                <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <a href="{{ $image->image_url }}" target="_blank">
                                            <img src="{{ $image->image_url }}" class="card-img-top rounded-top" style="height:220px;object-fit:cover;">
                                        </a>

                                        <div class="card-body">
                                            @if($image->title)
                                                <h6 class="fw-bold mb-2">{{ $image->title }}</h6>
                                            @endif

                                            @if($image->caption)
                                                <p class="text-muted small mb-2">
                                                    {{ $image->caption }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="card-footer bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    Order
                                                    <strong>{{ $image->sort_order ?? $image->id }}</strong>
                                                </small>
                                                @if($image->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(function(){
            $('.gallery-popup').on('click',function(e){
                e.preventDefault();
                let image=$(this).attr('href');

                Swal.fire({
                    imageUrl:image,
                    imageAlt:'Gallery Image',
                    showConfirmButton:false,
                    showCloseButton:true,
                    width:900,
                    padding:'1rem',
                    background:'#fff'
                });
            });
        });
    </script>
@endpush
