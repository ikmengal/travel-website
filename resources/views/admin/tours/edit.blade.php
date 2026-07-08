@extends('admin.layouts.app')
@section('title', $title)
@section('content')
{{-- ===========================================================
    PAGE HEADER
    =========================================================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>

            <h4 class="fw-bold mb-1">

                <i class="ti ti-edit text-warning me-2"></i>

                Edit Tour

            </h4>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb mb-0">

                    <li class="breadcrumb-item">

                        <a href="{{ route('admin.dashboard') }}">

                            Dashboard

                        </a>

                    </li>

                    <li class="breadcrumb-item">

                        <a href="{{ route('tours.index') }}">

                            Tours

                        </a>

                    </li>

                    <li class="breadcrumb-item active">

                        Edit Tour

                    </li>

                </ol>

            </nav>

        </div>

        <div class="d-flex gap-2">

            @can('tours-show')
                <a href="{{ route('tours.show',$tour->id) }}"
                    class="btn btn-info">

                    <i class="ti ti-eye me-1"></i>

                    View

                </a>
            @endcan

            <a href="{{ route('tours.index') }}"
                class="btn btn-label-secondary">

                <i class="ti ti-arrow-left me-1"></i>

                Back

            </a>

        </div>
    </div>

    {{-- ===========================================================
    FORM
    =========================================================== --}}
    <form action="{{ route('tours.update',$tour->id) }}" method="POST" enctype="multipart/form-data" id="tourForm">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- ===================================================
            LEFT CONTENT
            ==================================================== --}}
            <div class="col-lg-8">

                {{-- ===================================================
                CURRENT TOUR
                ==================================================== --}}
                <div class="card mb-4">

                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-md-3">

                                <img
                                    id="currentImage"
                                    src="{{ $tour->featured_image ? asset($tour->featured_image) : asset('admin/assets/img/illustrations/placeholder.jpg') }}"
                                    class="img-fluid rounded shadow-sm border"
                                    style="height:180px;width:100%;object-fit:cover;">

                            </div>

                            <div class="col-md-9">

                                <div class="d-flex justify-content-between align-items-start">

                                    <div>

                                        <span class="badge bg-label-primary mb-2">

                                            {{ $tour->tour_code }}

                                        </span>

                                        <h3 class="mb-1">

                                            {{ $tour->title }}

                                        </h3>

                                        @if($tour->tagline)

                                            <p class="text-muted mb-2">

                                                {{ $tour->tagline }}

                                            </p>

                                        @endif

                                        <div class="d-flex flex-wrap gap-2">

                                            @if($tour->status)

                                                <span class="badge bg-success">

                                                    Active

                                                </span>

                                            @else

                                                <span class="badge bg-danger">

                                                    Inactive

                                                </span>

                                            @endif

                                            @if($tour->featured)

                                                <span class="badge bg-warning">

                                                    Featured

                                                </span>
                                            @endif

                                            @if($tour->popular)

                                                <span class="badge bg-info">

                                                    Popular

                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                    <div class="text-end">

                                        <h3 class="text-primary mb-0">

                                            ${{ number_format($tour->discount_price ?: $tour->price,2) }}

                                        </h3>

                                        @if($tour->discount_price)

                                            <small class="text-decoration-line-through text-muted">

                                                ${{ number_format($tour->price,2) }}

                                            </small>
                                        @endif

                                    </div>

                                </div>

                                <hr>

                                <div class="row text-center">

                                    <div class="col-4">

                                        <h5 class="mb-0">

                                            {{ $tour->duration_days }}

                                        </h5>

                                        <small class="text-muted">

                                            Days

                                        </small>

                                    </div>

                                    <div class="col-4">

                                        <h5 class="mb-0">

                                            {{ $tour->duration_nights }}

                                        </h5>

                                        <small class="text-muted">

                                            Nights

                                        </small>

                                    </div>

                                    <div class="col-4">

                                        <h5 class="mb-0">

                                            {{ $tour->max_people }}

                                        </h5>

                                        <small class="text-muted">

                                            Max People

                                        </small>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
                BASIC INFORMATION
                =========================================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-info-circle me-2 text-primary"></i>

                            Basic Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Tour Title --}}
                            <div class="col-md-12 mb-3">

                                <label class="form-label">

                                    Tour Title
                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title',$tour->title) }}"
                                    placeholder="Enter Tour Title">

                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Slug --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Slug

                                </label>

                                <input
                                    type="text"
                                    id="slug"
                                    class="form-control"
                                    value="{{ old('slug',$tour->slug) }}"
                                    readonly>

                            </div>


                            {{-- Tour Code --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Tour Code
                                    <span class="text-danger">*</span>

                                </label>

                                <div class="input-group">

                                    <input
                                        type="text"
                                        id="tour_code"
                                        name="tour_code"
                                        class="form-control @error('tour_code') is-invalid @enderror"
                                        value="{{ old('tour_code',$tour->tour_code) }}">

                                    <button
                                        class="btn btn-outline-primary"
                                        type="button"
                                        id="generateCode">

                                        <i class="ti ti-refresh"></i>

                                    </button>

                                </div>

                                @error('tour_code')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Tagline --}}
                            <div class="col-md-12 mb-3">

                                <label class="form-label">

                                    Tagline

                                </label>

                                <input
                                    type="text"
                                    name="tagline"
                                    class="form-control @error('tagline') is-invalid @enderror"
                                    value="{{ old('tagline',$tour->tagline) }}"
                                    placeholder="Amazing Experience Awaits...">

                                @error('tagline')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Short Description --}}
                            <div class="col-md-12">

                                <label class="form-label">

                                    Short Description

                                </label>

                                <textarea
                                    rows="5"
                                    maxlength="500"
                                    id="short_description"
                                    name="short_description"
                                    class="form-control @error('short_description') is-invalid @enderror"
                                    placeholder="Short description...">{{ old('short_description',$tour->short_description) }}</textarea>

                                @error('short_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="d-flex justify-content-between mt-2">

                                    <small class="text-muted">

                                        Recommended:
                                        150 - 300 Characters

                                    </small>

                                    <small>

                                        <span id="shortCount">

                                            {{ strlen(old('short_description',$tour->short_description ?? '')) }}

                                        </span>/500

                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
                LIVE TOUR PREVIEW
                =========================================================== --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-device-desktop me-2 text-success"></i>

                            Live Preview

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="border rounded-3 p-4">

                            <h3
                                class="fw-bold mb-2"
                                id="previewTitle">

                                {{ old('title',$tour->title) }}

                            </h3>

                            <p
                                class="text-muted mb-3"
                                id="previewTagline">

                                {{ old('tagline',$tour->tagline) }}

                            </p>

                            <p
                                id="previewShortDescription">

                                {{ old('short_description',$tour->short_description) }}

                            </p>

                            <hr>

                            <div class="d-flex flex-wrap gap-3">

                                <span class="badge bg-label-primary">

                                    Code:
                                    <span id="previewCode">

                                        {{ old('tour_code',$tour->tour_code) }}

                                    </span>

                                </span>

                                <span class="badge bg-label-success">

                                    <span id="previewDays">

                                        {{ old('duration_days',$tour->duration_days) }}

                                    </span>
                                    Days

                                </span>

                                <span class="badge bg-label-warning">

                                    <span id="previewNights">

                                        {{ old('duration_nights',$tour->duration_nights) }}

                                    </span>
                                    Nights

                                </span>

                                <span class="badge bg-label-info">

                                    Max
                                    <span id="previewPeople">

                                        {{ old('max_people',$tour->max_people) }}

                                    </span>
                                    People

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
                PRICING & TOUR DETAILS
                =========================================================== --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-currency-dollar me-2 text-success"></i>

                            Pricing & Tour Details

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Price --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Regular Price
                                    <span class="text-danger">*</span>

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        $

                                    </span>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="price"
                                        name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price',$tour->price) }}">

                                </div>

                                @error('price')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>



                            {{-- Discount Price --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Discount Price

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        $

                                    </span>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="discount_price"
                                        name="discount_price"
                                        class="form-control @error('discount_price') is-invalid @enderror"
                                        value="{{ old('discount_price',$tour->discount_price) }}">

                                </div>

                                @error('discount_price')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>



                            {{-- Days --}}
                            <div class="col-md-3 mb-3">

                                <label class="form-label">

                                    Duration Days

                                </label>

                                <input
                                    type="number"
                                    min="1"
                                    id="duration_days"
                                    name="duration_days"
                                    class="form-control @error('duration_days') is-invalid @enderror"
                                    value="{{ old('duration_days',$tour->duration_days) }}">

                                @error('duration_days')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>



                            {{-- Nights --}}
                            <div class="col-md-3 mb-3">

                                <label class="form-label">

                                    Duration Nights

                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    id="duration_nights"
                                    name="duration_nights"
                                    class="form-control @error('duration_nights') is-invalid @enderror"
                                    value="{{ old('duration_nights',$tour->duration_nights) }}">

                                @error('duration_nights')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>



                            {{-- Max People --}}
                            <div class="col-md-3 mb-3">

                                <label class="form-label">

                                    Max People

                                </label>

                                <input
                                    type="number"
                                    min="1"
                                    name="max_people"
                                    id="max_people"
                                    class="form-control @error('max_people') is-invalid @enderror"
                                    value="{{ old('max_people',$tour->max_people) }}">

                                @error('max_people')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>



                            {{-- Min Age --}}
                            <div class="col-md-3 mb-3">

                                <label class="form-label">

                                    Minimum Age

                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    name="min_age"
                                    class="form-control @error('min_age') is-invalid @enderror"
                                    value="{{ old('min_age',$tour->min_age) }}">

                                @error('min_age')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
                PRICE SUMMARY
                =========================================================== --}}
                <div class="card mb-4 border-success">

                    <div class="card-header bg-label-success">

                        <h5 class="mb-0">

                            <i class="ti ti-receipt-2 me-2"></i>

                            Live Price Summary

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row text-center">

                            <div class="col-md-3">

                                <small class="text-muted d-block">

                                    Regular Price

                                </small>

                                <h3
                                    id="previewPrice"
                                    class="text-primary mt-2">

                                    ${{ number_format(old('price',$tour->price),2) }}

                                </h3>

                            </div>

                            <div class="col-md-3">

                                <small class="text-muted d-block">

                                    Discount Price

                                </small>

                                <h3
                                    id="previewDiscount"
                                    class="text-success mt-2">

                                    @if($tour->discount_price)

                                        ${{ number_format(old('discount_price',$tour->discount_price),2) }}

                                    @else

                                        $0.00

                                    @endif

                                </h3>

                            </div>

                            <div class="col-md-3">

                                <small class="text-muted d-block">

                                    You Save

                                </small>

                                <h3
                                    id="discountAmount"
                                    class="text-danger mt-2">

                                    @if($tour->discount_price)

                                        ${{ number_format($tour->price-$tour->discount_price,2) }}

                                    @else

                                        $0.00

                                    @endif

                                </h3>

                            </div>

                            <div class="col-md-3">

                                <small class="text-muted d-block">

                                    Discount %

                                </small>

                                <h3
                                    id="discountPercent"
                                    class="text-warning mt-2">

                                    @if($tour->discount_price)

                                        {{ number_format((($tour->price-$tour->discount_price)/$tour->price)*100,1) }}%

                                    @else

                                        0%

                                    @endif

                                </h3>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
                DESCRIPTION & SEO
                =========================================================== --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-align-left me-2 text-primary"></i>

                            Tour Description

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Description

                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="12"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description',$tour->description) }}</textarea>

                            @error('description')

                                <div class="invalid-feedback d-block">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
                SEO INFORMATION
                =========================================================== --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-world me-2 text-success"></i>

                            SEO Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Meta Title --}}
                            <div class="col-md-12 mb-4">

                                <label class="form-label">

                                    Meta Title

                                </label>

                                <input
                                    type="text"
                                    id="meta_title"
                                    name="meta_title"
                                    maxlength="60"
                                    class="form-control @error('meta_title') is-invalid @enderror"
                                    value="{{ old('meta_title',$tour->meta_title) }}"
                                    placeholder="Meta Title">

                                @error('meta_title')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                                <div class="d-flex justify-content-between mt-2">

                                    <small class="text-muted">

                                        Recommended 50 - 60 Characters

                                    </small>

                                    <small>

                                        <span id="metaTitleCount">

                                            {{ strlen(old('meta_title',$tour->meta_title ?? '')) }}

                                        </span>/60

                                    </small>

                                </div>

                            </div>



                            {{-- Meta Description --}}
                            <div class="col-md-12">

                                <label class="form-label">

                                    Meta Description

                                </label>

                                <textarea
                                    id="meta_description"
                                    name="meta_description"
                                    rows="5"
                                    maxlength="160"
                                    class="form-control @error('meta_description') is-invalid @enderror"
                                    placeholder="Meta Description">{{ old('meta_description',$tour->meta_description) }}</textarea>

                                @error('meta_description')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                                <div class="d-flex justify-content-between mt-2">

                                    <small class="text-muted">

                                        Recommended 150 - 160 Characters

                                    </small>

                                    <small>

                                        <span id="metaDescriptionCount">

                                            {{ strlen(old('meta_description',$tour->meta_description ?? '')) }}

                                        </span>/160

                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
                GOOGLE PREVIEW
                =========================================================== --}}
                <div class="card mb-4 border-success">

                    <div class="card-header bg-label-success">

                        <h5 class="mb-0">

                            <i class="ti ti-brand-google me-2"></i>

                            Google Search Preview

                        </h5>

                    </div>

                    <div class="card-body">

                        <div
                            id="seoPreviewTitle"
                            class="fw-bold text-primary fs-5">

                            {{ old('meta_title',$tour->meta_title ?: $tour->title) }}

                        </div>

                        <div class="text-success small mb-2">

                            {{ url('tours') }}/

                            <span id="seoPreviewSlug">

                                {{ old('slug',$tour->slug) }}

                            </span>

                        </div>

                        <div
                            id="seoPreviewDescription"
                            class="text-muted">

                            {{ old('meta_description',$tour->meta_description ?: $tour->short_description) }}

                        </div>

                    </div>

                </div>

                {{-- ===========================================================
                RIGHT SIDEBAR
                =========================================================== --}}

            </div>

            <div class="col-lg-4">
                {{-- =======================================================
                PUBLISH
                ======================================================== --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-send me-2 text-primary"></i>

                            Publish

                        </h5>

                    </div>

                    <div class="card-body">

                        {{-- Status --}}
                        <div class="form-check form-switch mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="status"
                                name="status"
                                value="1"
                                {{ old('status',$tour->status) ? 'checked' : '' }}>

                            <label
                                class="form-check-label fw-semibold"
                                for="status">

                                Active Tour

                            </label>

                        </div>

                        {{-- Featured --}}
                        <div class="form-check form-switch mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="featured"
                                name="featured"
                                value="1"
                                {{ old('featured',$tour->featured) ? 'checked' : '' }}>

                            <label
                                class="form-check-label fw-semibold"
                                for="featured">

                                Featured Tour

                            </label>

                        </div>

                        {{-- Popular --}}
                        <div class="form-check form-switch mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="popular"
                                name="popular"
                                value="1"
                                {{ old('popular',$tour->popular) ? 'checked' : '' }}>

                            <label
                                class="form-check-label fw-semibold"
                                for="popular">

                                Popular Tour

                            </label>

                        </div>

                        {{-- Sort Order --}}
                        <div>

                            <label class="form-label">

                                Sort Order

                            </label>

                            <input
                                type="number"
                                min="0"
                                name="sort_order"
                                class="form-control"
                                value="{{ old('sort_order',$tour->sort_order) }}">

                        </div>

                    </div>

                </div>

                {{-- =======================================================
                DESTINATION
                ======================================================== --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-map-pin me-2 text-success"></i>

                            Destination

                        </h5>

                    </div>

                    <div class="card-body">

                        {{-- Destination --}}
                        <div class="mb-3">

                            <label class="form-label">

                                Destination
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="destination_id"
                                class="form-select select2 @error('destination_id') is-invalid @enderror">

                                <option value="">

                                    Select Destination

                                </option>

                                @foreach($destinations as $destination)

                                    <option
                                        value="{{ $destination->id }}"
                                        {{ old('destination_id',$tour->destination_id)==$destination->id ? 'selected' : '' }}>

                                        {{ $destination->name }}

                                    </option>

                                @endforeach

                            </select>

                            @error('destination_id')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- Category --}}
                        <div>

                            <label class="form-label">

                                Tour Category

                            </label>

                            <select
                                name="tour_category_id"
                                class="form-select select2">

                                <option value="">

                                    Select Category

                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('tour_category_id',$tour->tour_category_id)==$category->id ? 'selected' : '' }}>

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                {{-- =======================================================
                FEATURED IMAGE
                ======================================================== --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-photo me-2 text-info"></i>

                            Featured Image

                        </h5>

                    </div>

                    <div class="card-body">

                        {{-- Current Image --}}
                        <div class="mb-3">

                            <img
                                id="previewImage"
                                src="{{ $tour->featured_image ? asset($tour->featured_image) : asset('admin/assets/img/illustrations/placeholder.jpg') }}"
                                class="img-fluid rounded border shadow-sm"
                                style="width:100%;height:240px;object-fit:cover;">

                        </div>

                        {{-- Upload --}}
                        <input
                            type="file"
                            name="featured_image"
                            id="featured_image"
                            accept="image/*"
                            class="form-control @error('featured_image') is-invalid @enderror">

                        @error('featured_image')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                        <small class="text-muted mt-2 d-block">

                            Recommended Size:
                            <strong>1200 × 800 px</strong>

                        </small>

                    </div>

                </div>

                {{-- =======================================================
                SAVE BUTTONS
                ======================================================== --}}
                <div class="card">

                    <div class="card-body">

                        <div class="d-grid gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="ti ti-device-floppy me-1"></i>

                                Update Tour

                            </button>

                            <a
                                href="{{ route('tours.show',$tour->id) }}"
                                class="btn btn-label-info">

                                <i class="ti ti-eye me-1"></i>

                                View Tour

                            </a>

                            <a
                                href="{{ route('tours.index') }}"
                                class="btn btn-outline-secondary">

                                <i class="ti ti-arrow-left me-1"></i>

                                Back To List

                            </a>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </form>
@endsection
@push('js')
    <script>
        $(function () {
            // ==========================================================
            // SELECT2
            // ==========================================================
            $('.select2').select2({
                width: '100%'
            });

            // ==========================================================
            // SUMMERNOTE / CKEDITOR
            // ==========================================================
            if ($.fn.summernote) {

                $('#description').summernote({
                    height: 350,
                    placeholder: 'Write complete tour description...'
                });

            } else if (typeof CKEDITOR !== "undefined") {

                CKEDITOR.replace('description', {
                    height: 350
                });

            }

            // ==========================================================
            // AUTO SLUG
            // ==========================================================
            $('#title').keyup(function () {

                let title = $(this).val();

                let slug = title
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-|-$/g, '');

                $('#slug').val(slug);

                $('#seoPreviewSlug').text(slug);

                $('#previewTitle').text(title);

                if ($('#meta_title').val() == '') {

                    $('#seoPreviewTitle').text(title);

                }

            });

            // ==========================================================
            // TAGLINE PREVIEW
            // ==========================================================
            $('input[name="tagline"]').keyup(function () {

                $('#previewTagline').text($(this).val());

            });

            // ==========================================================
            // TOUR CODE
            // ==========================================================
            $('#tour_code').keyup(function(){

                $('#previewCode').text($(this).val());

            });

            $('#generateCode').click(function(){

                let random = Math.floor(Math.random() * 9000) + 1000;

                $('#tour_code').val('TR-' + random).trigger('keyup');

            });

            // ==========================================================
            // SHORT DESCRIPTION
            // ==========================================================
            $('#short_description').keyup(function(){

                $('#shortCount').text($(this).val().length);

                $('#previewShortDescription').text($(this).val());

                if($('#meta_description').val()==''){

                    $('#seoPreviewDescription').text($(this).val());

                }

            });

            // ==========================================================
            // META TITLE
            // ==========================================================
            $('#meta_title').keyup(function(){

                $('#metaTitleCount').text($(this).val().length);

                $('#seoPreviewTitle').text($(this).val());

            });

            // ==========================================================
            // META DESCRIPTION
            // ==========================================================
            $('#meta_description').keyup(function(){

                $('#metaDescriptionCount').text($(this).val().length);

                $('#seoPreviewDescription').text($(this).val());

            });

            // ==========================================================
            // PRICE CALCULATION
            // ==========================================================
            $('#price,#discount_price').keyup(function(){

                calculatePrice();

            });

            calculatePrice();

            function calculatePrice(){

                let price = parseFloat($('#price').val()) || 0;

                let discount = parseFloat($('#discount_price').val()) || 0;

                $('#previewPrice').text('$'+price.toFixed(2));

                $('#previewDiscount').text('$'+discount.toFixed(2));

                if(price>0 && discount>0){

                    let save = price-discount;

                    let percent = (save/price)*100;

                    $('#discountAmount').text('$'+save.toFixed(2));

                    $('#discountPercent').text(percent.toFixed(1)+'%');

                }else{

                    $('#discountAmount').text('$0.00');

                    $('#discountPercent').text('0%');

                }

            }

            // ==========================================================
            // DAYS
            // ==========================================================
            $('#duration_days').keyup(function(){

                $('#previewDays').text($(this).val());

            });

            // ==========================================================
            // NIGHTS
            // ==========================================================
            $('#duration_nights').keyup(function(){

                $('#previewNights').text($(this).val());

            });

            // ==========================================================
            // MAX PEOPLE
            // ==========================================================
            $('#max_people').keyup(function(){

                $('#previewPeople').text($(this).val());

            });

            // ==========================================================
            // IMAGE PREVIEW
            // ==========================================================
            $('#featured_image').change(function(e){

                let reader = new FileReader();

                reader.onload = function(event){

                    $('#previewImage').attr('src',event.target.result);

                    $('#currentImage').attr('src',event.target.result);

                }

                reader.readAsDataURL(e.target.files[0]);

            });

            // ==========================================================
            // FORM VALIDATION
            // ==========================================================
            $('#tourForm').submit(function(){

                let title = $('#title').val().trim();

                let destination = $('[name=destination_id]').val();

                let price = $('#price').val();

                let days = $('#duration_days').val();

                if(title==""){

                    toastr.error("Tour title is required.");

                    $('#title').focus();

                    return false;

                }

                if(destination==""){

                    toastr.error("Please select destination.");

                    return false;

                }

                if(price=="" || parseFloat(price)<=0){

                    toastr.error("Price must be greater than zero.");

                    $('#price').focus();

                    return false;

                }

                if(days==""){

                    toastr.error("Duration days required.");

                    $('#duration_days').focus();

                    return false;

                }

                return true;

            });

        });
    </script>
@endpush
