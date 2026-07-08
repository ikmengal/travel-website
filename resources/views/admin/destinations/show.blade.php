@extends('admin.layouts.app')
@section('title','Destination Details')
@push('css')
    <style>
        .gallery-card{
            transition:.3s;
            overflow:hidden;
        }
        .gallery-card:hover{
            transform:translateY(-6px);
            box-shadow:0 .75rem 1.5rem rgba(0,0,0,.15)!important;
        }
        .gallery-card img{
            transition:.4s;
        }
        .gallery-card:hover img{
            transform:scale(1.08);
        }
        .destination-description img{
            max-width:100%;
            height:auto;
            border-radius:8px;
        }
        .destination-description table{
            width:100%;
        }
    </style>
@endpush
@section('content')
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-map-pin text-primary me-2"></i>
                Destination Details
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('destinations.index') }}">
                            Destinations
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $destination->name }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2">
            @can('destinations-edit')
                <a
                    href="{{ route('destinations.edit',$destination) }}"
                    class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan
            @can('destinations-delete')
                <button
                    class="btn btn-danger deleteRecord"
                    data-url="{{ route('destinations.destroy',$destination) }}">
                    <i class="ti ti-trash me-1"></i>
                    Delete
                </button>
            @endcan
            <a
                href="{{ route('destinations.index') }}"
                class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    {{-- Hero Banner --}}
    <div class="card overflow-hidden mb-4">
        <div class="position-relative">
            <img
                src="{{ asset('images/destinations/'.$destination->banner_image) }}"
                class="w-100"
                style="height:350px;object-fit:cover;">

            <div
                class="position-absolute top-0 start-0 w-100 h-100"
                style="background:linear-gradient(180deg,rgba(0,0,0,.15),rgba(0,0,0,.70));">
            </div>

            <div
                class="position-absolute bottom-0 start-0 text-white p-4">
                <div class="d-flex align-items-center">
                    <img
                        src="{{ asset('images/destinations/'.$destination->featured_image) }}"
                        class="rounded shadow border border-3 border-white"
                        style="width:120px;height:120px;object-fit:cover;">

                    <div class="ms-4">
                        <h2 class="text-white mb-1">
                            {{ $destination->name }}
                        </h2>
                        @if($destination->tagline)
                            <p class="mb-2 fs-5">
                                {{ $destination->tagline }}
                            </p>
                        @endif
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-label-info">
                                <i class="ti ti-world me-1"></i>
                                {{ $destination->country->name }}
                            </span>
                            @if($destination->state)
                                <span class="badge bg-label-warning">
                                    {{ $destination->state->name }}
                                </span>
                            @endif
                            @if($destination->city)
                                <span class="badge bg-label-success">
                                    {{ $destination->city->name }}
                                </span>
                            @endif
                            @if($destination->is_featured)
                                <span class="badge bg-primary">
                                    <i class="ti ti-star-filled me-1"></i>
                                    Featured
                                </span>
                            @endif

                            @if($destination->is_popular)
                                <span class="badge bg-danger">
                                    <i class="ti ti-fire me-1"></i>
                                    Popular
                                </span>
                            @endif
                            @if($destination->status)
                                <span class="badge bg-success">
                                    Active
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Total Tours
                            </small>
                            <h3 class="mb-0 mt-2">
                                {{ $destination->tours()->count() }}
                            </h3>
                        </div>
                        <div
                            class="badge bg-label-primary">
                            <span class="avatar-initial">
                                <i class="ti ti-route fs-1 my-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Hotels
                            </small>
                            <h3 class="mb-0 mt-2">
                                {{ $destination->hotels()->count() }}
                            </h3>
                        </div>
                        <div
                            class="badge bg-label-success">
                            <span class="avatar-initial">
                                <i class="ti ti-building-skyscraper fs-1 my-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Gallery Images
                            </small>
                            <h3 class="mb-0 mt-2">
                                {{ $destination->images()->count() }}
                            </h3>
                        </div>
                        <div
                            class="badge bg-label-warning">
                            <span class="avatar-initial">
                                <i class="ti ti-photo fs-1 my-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                Starting Price
                            </small>
                            <h3 class="mb-0 mt-2">
                                ${{ number_format($destination->starting_price,2) }}
                            </h3>
                        </div>
                        <div class="badge bg-label-danger">
                            <span class="avatar-initial">
                                <i class="ti ti-currency-dollar fs-1 my-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- General Information --}}
        <div class="col-xl-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-info-circle text-primary me-2"></i>
                        General Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-muted small">
                                Destination Name
                            </label>
                            <h6 class="mb-0">
                                {{ $destination->name }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Slug
                            </label>
                            <h6 class="mb-0">
                                {{ $destination->slug }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Country
                            </label>
                            <h6 class="mb-0">
                                <i class="ti ti-world text-primary me-1"></i>
                                {{ $destination->country?->name }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                State
                            </label>
                            <h6 class="mb-0">
                                {{ $destination->state?->name ?? 'N/A' }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                City
                            </label>
                            <h6 class="mb-0">
                                {{ $destination->city?->name ?? 'N/A' }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Best Time To Visit
                            </label>
                            <h6 class="mb-0">
                                {{ $destination->best_time_to_visit ?: 'N/A' }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Starting Price
                            </label>
                            <h6 class="text-success mb-0">
                                ${{ number_format($destination->starting_price,2) }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Sort Order
                            </label>
                            <h6 class="mb-0">
                                {{ $destination->sort_order }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-adjustments-check text-success me-2"></i>
                        Status
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <small class="text-muted">
                            Featured
                        </small>
                        <div class="mt-1">
                            @if($destination->is_featured)
                                <span class="badge bg-primary">
                                    <i class="ti ti-star-filled me-1"></i>
                                    Featured Destination
                                </span>
                            @else
                                <span class="badge bg-label-secondary">
                                    No
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted">
                            Popular
                        </small>
                        <div class="mt-1">
                            @if($destination->is_popular)
                                <span class="badge bg-danger">
                                    <i class="ti ti-fire me-1"></i>
                                    Popular
                                </span>
                            @else
                                <span class="badge bg-label-secondary">
                                    No
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted">
                            Current Status
                        </small>
                        <div class="mt-1">
                            @if($destination->status)
                                <span class="badge bg-success">
                                    Active
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <small class="text-muted">
                            Gallery Images
                        </small>
                        <h3 class="mt-1 mb-0">
                            {{ $destination->images()->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Location --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="ti ti-map-pin text-danger me-2"></i>
                Geo Location
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="text-muted small">
                        Latitude
                    </label>
                    <h6>
                        {{ $destination->latitude ?: 'N/A' }}
                    </h6>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">
                        Longitude
                    </label>
                    <h6>
                        {{ $destination->longitude ?: 'N/A' }}
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Description --}}
        <div class="col-xl-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="ti ti-file-description text-primary me-2"></i>
                        Destination Description
                    </h5>
                    @if($destination->tagline)
                        <span class="badge bg-label-primary">
                            {{ $destination->tagline }}
                        </span>
                    @endif
                </div>

                <div class="card-body">
                    {{-- Short Description --}}
                    <div class="mb-4">
                        <h6 class="fw-semibold">
                            Short Description
                        </h6>
                        @if($destination->short_description)
                            <p class="text-muted mb-0">
                                {{ $destination->short_description }}
                            </p>
                        @else
                            <div class="alert alert-warning mb-0">
                                No short description available.
                            </div>
                        @endif
                    </div>
                    <hr>

                    {{-- Long Description --}}
                    <div>
                        <h6 class="fw-semibold mb-3">
                            Full Description
                        </h6>
                        @if($destination->description)
                            <div
                                class="ck-content destination-description">
                                {!! $destination->description !!}
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                No description available.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO Information --}}
        <div class="col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-seo text-success me-2"></i>
                        SEO Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <small class="text-muted">
                            Meta Title
                        </small>
                        <div class="fw-semibold mt-1">
                            {{ $destination->meta_title ?: 'Not Available' }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted">
                            Meta Description
                        </small>
                        <div class="mt-1">
                            {{ $destination->meta_description ?: 'Not Available' }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted">
                            URL Slug
                        </small>
                        <div class="mt-1">
                            <code>
                                {{ $destination->slug }}
                            </code>
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted">
                            SEO URL
                        </small>
                        <div class="mt-1">
                            <a
                                href="{{ url('/destination/'.$destination->slug) }}"
                                target="_blank">
                                {{ url('/destination/'.$destination->slug) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dates --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-calendar-event text-info me-2"></i>
                        Record Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">
                            Created At
                        </small>
                        <div class="fw-semibold">
                            {{ $destination->created_at->format('d M, Y h:i A') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            Last Updated
                        </small>
                        <div class="fw-semibold">
                            {{ $destination->updated_at->format('d M, Y h:i A') }}
                        </div>
                    </div>

                    @if($destination->deleted_at)
                        <div>
                            <small class="text-muted">
                                Deleted At
                            </small>
                            <div class="text-danger fw-semibold">
                                {{ $destination->deleted_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Featured Image --}}
        <div class="col-xl-4 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="ti ti-photo text-primary me-2"></i>
                        Featured Image
                    </h5>
                    @if($destination->featured_image)
                        <a href="{{ asset('images/destinations/'.$destination->featured_image) }}"
                            target="_blank"
                            class="btn btn-sm btn-label-primary">
                            <i class="ti ti-external-link"></i>
                            View Full
                        </a>
                    @endif
                </div>
                <div class="card-body text-center">
                    @if($destination->featured_image)
                        <a href="{{ asset('images/destinations/'.$destination->featured_image) }}"
                            data-fslightbox="destination-images">
                            <img
                                src="{{ asset('images/destinations/'.$destination->featured_image) }}"
                                class="img-fluid rounded shadow"
                                style="max-height:350px;object-fit:cover;width:100%;">
                        </a>
                    @else
                        <div class="py-5">
                            <i class="ti ti-photo-off display-4 text-muted"></i>
                            <h6 class="mt-3 text-muted">
                                No Featured Image
                            </h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Banner Image --}}
        <div class="col-xl-4 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="ti ti-panorama-horizontal text-success me-2"></i>
                        Banner Image
                    </h5>
                    @if($destination->banner_image)
                        <a href="{{ asset('images/destinations/'.$destination->banner_image) }}"
                            target="_blank" class="btn btn-sm btn-label-success">
                            <i class="ti ti-external-link"></i>
                            View Full
                        </a>
                    @endif
                </div>

                <div class="card-body text-center">
                    @if($destination->banner_image)
                        <a href="{{ asset('images/destinations/'.$destination->banner_image) }}" data-fslightbox="destination-images">
                            <img src="{{ asset('images/destinations/'.$destination->banner_image) }}" class="img-fluid rounded shadow"
                                style="max-height:350px;width:100%;object-fit:cover;">
                        </a>
                    @else
                        <div class="py-5">
                            <i class="ti ti-photo-off display-4 text-muted"></i>
                            <h6 class="mt-3 text-muted">
                                No Banner Image
                            </h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Gallery --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    <i class="ti ti-layout-grid text-warning me-2"></i>
                    Destination Gallery
                </h5>

                <small class="text-muted">
                    Total Images :
                    {{ $destination->images->count() }}
                </small>
            </div>
        </div>

        <div class="card-body">
            @if($destination->images->count())
                <div class="row">
                    @foreach($destination->images as $image)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm gallery-card">
                                <a href="{{ asset('images/destinations/'.$image->image) }}"
                                    data-fslightbox="destination-images">
                                    <img src="{{ asset('images/destinations/'.$image->image) }}"
                                        class="card-img-top" style="height:220px;object-fit:cover;">
                                </a>

                                <div class="card-body py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            #{{ $loop->iteration }}
                                        </small>
                                        <small class="badge bg-label-primary">
                                            {{ $image->sort_order }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-photo-off display-3 text-muted"></i>
                    <h5 class="mt-3">
                        No Gallery Images Found
                    </h5>
                    <p class="text-muted mb-0">
                        Gallery images will appear here.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fslightbox/index.js"></script>
    <script>
        $(document).on('click','.deleteRecord',function(e){
            e.preventDefault();
            let url=$(this).data('url');

            Swal.fire({

                title:'Delete Destination?',

                text:'This action cannot be undone.',

                icon:'warning',

                showCancelButton:true,

                confirmButtonColor:'#d33',

                cancelButtonColor:'#696cff',

                confirmButtonText:'Delete'

            }).then((result)=>{

                if(!result.isConfirmed) return;

                $.ajax({

                    url:url,

                    type:'DELETE',

                    data:{
                        _token:"{{ csrf_token() }}"
                    },

                    success:function(res){

                        toastr.success(res.message);

                        setTimeout(function(){

                            window.location="{{ route('destinations.index') }}";

                        },1200);

                    },

                    error:function(){

                        toastr.error("Unable to delete destination.");

                    }

                });

            });
        });
    </script>
@endpush
