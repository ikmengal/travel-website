@extends('admin.layouts.app')
@section('title',$title)
@section('content')
{{------------- PAGE HEADER -------------}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="ti ti-route-2 text-primary me-2"></i>
            Create Tour
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
                    Create
                </li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('tours.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>
</div>

<form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        {{------------- LEFT SIDE -------------}}
        <div class="col-lg-8">
            {{-- General Information --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-info-circle text-primary me-2"></i>
                        General Information
                    </h5>
                </div>
                <div class="card-body">
                    {{------------- GENERAL INFORMATION -------------}}
                    <div class="row">

                        {{-- Tour Title --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Tour Title <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Enter Tour Title"
                                value="{{ old('title') }}">

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Slug --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Slug <span class="text-danger">*</span>

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="ti ti-link"></i>
                                </span>

                                <input
                                    type="text"
                                    name="slug"
                                    id="slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    placeholder="tour-slug"
                                    value="{{ old('slug') }}">

                            </div>

                            @error('slug')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Tour Code --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Tour Code <span class="text-danger">*</span>

                            </label>

                            <div class="input-group">

                                <input
                                    type="text"
                                    name="tour_code"
                                    id="tour_code"
                                    class="form-control @error('tour_code') is-invalid @enderror"
                                    placeholder="TR-0001"
                                    value="{{ old('tour_code') }}">

                                <button
                                    type="button"
                                    class="btn btn-outline-primary"
                                    id="generateCode">

                                    Generate

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
                                placeholder="Amazing Experience Awaits..."
                                value="{{ old('tagline') }}">

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
                                rows="4"
                                name="short_description"
                                class="form-control @error('short_description') is-invalid @enderror"
                                placeholder="Write short description...">{{ old('short_description') }}</textarea>

                            <div class="d-flex justify-content-between mt-1">

                                <small class="text-muted">

                                    Maximum 255 characters recommended.

                                </small>

                                <small>

                                    <span id="shortCount">0</span>/255

                                </small>

                            </div>

                            @error('short_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>
                </div>
            </div>
            {{-- Pricing --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-currency-dollar text-success me-2"></i>
                        Pricing
                    </h5>
                </div>
                <div class="card-body">
                    {{------------- PRICING & TOUR DETAILS -------------}}
                    <div class="row">

                        {{-- Regular Price --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Regular Price <span class="text-danger">*</span>

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    $
                                </span>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="price"
                                    id="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    placeholder="0.00"
                                    value="{{ old('price') }}">

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
                                    name="discount_price"
                                    id="discount_price"
                                    class="form-control @error('discount_price') is-invalid @enderror"
                                    placeholder="0.00"
                                    value="{{ old('discount_price') }}">

                            </div>

                            @error('discount_price')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Discount Summary --}}
                        <div class="col-md-12 mb-4">

                            <div class="alert alert-primary d-flex justify-content-between align-items-center mb-0">

                                <div>

                                    <i class="ti ti-discount-2 me-2"></i>

                                    Discount Summary

                                </div>

                                <div>

                                    <span class="badge bg-primary">

                                        Saving :

                                        <span id="discountAmount">

                                            $0.00

                                        </span>

                                    </span>

                                    <span class="badge bg-success ms-2">

                                        <span id="discountPercent">

                                            0%

                                        </span>

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- Duration Days --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">

                                Duration Days <span class="text-danger">*</span>

                            </label>

                            <input
                                type="number"
                                min="1"
                                name="duration_days"
                                id="duration_days"
                                class="form-control @error('duration_days') is-invalid @enderror"
                                value="{{ old('duration_days') }}"
                                placeholder="5">

                            @error('duration_days')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Duration Nights --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">

                                Duration Nights <span class="text-danger">*</span>

                            </label>

                            <input
                                type="number"
                                min="0"
                                name="duration_nights"
                                id="duration_nights"
                                class="form-control @error('duration_nights') is-invalid @enderror"
                                value="{{ old('duration_nights') }}"
                                placeholder="4">

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
                                class="form-control @error('max_people') is-invalid @enderror"
                                value="{{ old('max_people',1) }}"
                                placeholder="20">

                            @error('max_people')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Minimum Age --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">

                                Minimum Age

                            </label>

                            <input
                                type="number"
                                min="0"
                                name="min_age"
                                class="form-control @error('min_age') is-invalid @enderror"
                                value="{{ old('min_age') }}"
                                placeholder="12">

                            @error('min_age')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Live Preview --}}
                        <div class="col-12">

                            <div class="card bg-label-primary border-0">

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-3">

                                            <small class="text-muted d-block">

                                                Regular Price

                                            </small>

                                            <h5 id="previewPrice">

                                                $0.00

                                            </h5>

                                        </div>

                                        <div class="col-md-3">

                                            <small class="text-muted d-block">

                                                Discount

                                            </small>

                                            <h5 class="text-success" id="previewDiscount">

                                                $0.00

                                            </h5>

                                        </div>

                                        <div class="col-md-3">

                                            <small class="text-muted d-block">

                                                Duration

                                            </small>

                                            <h5>

                                                <span id="previewDays">0</span>D /
                                                <span id="previewNights">0</span>N

                                            </h5>

                                        </div>

                                        <div class="col-md-3">

                                            <small class="text-muted d-block">

                                                Capacity

                                            </small>

                                            <h5>

                                                <span id="previewPeople">

                                                    1

                                                </span>

                                                Persons

                                            </h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-align-left me-2 text-info"></i>
                        Tour Description
                    </h5>
                </div>
                <div class="card-body">
                    {{------------- DESCRIPTION & SEO -------------}}
                    <div class="row">

                        {{-- Tour Description --}}
                        <div class="col-12 mb-4">

                            <label class="form-label">

                                Tour Description
                                <span class="text-danger">*</span>

                            </label>

                            <textarea
                                id="description"
                                name="description"
                                class="form-control">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">

                                Write complete details about this tour including highlights,
                                activities, accommodation, transportation and important notes.

                            </small>

                        </div>
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-world text-warning me-2"></i>
                        SEO Information
                    </h5>
                </div>

                <div class="card-body">
                    {{-- =========================================
                        SEO CARD
                    ========================================== --}}

                    <div class="col-12">

                        <div class="alert alert-label-warning mb-4">

                            <div class="d-flex">

                                <div class="me-3">

                                    <i class="ti ti-world fs-3"></i>

                                </div>

                                <div>

                                    <h6 class="mb-1">

                                        Search Engine Optimization (SEO)

                                    </h6>

                                    <small>

                                        Optimized SEO helps your tour rank better in Google
                                        search results.

                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Meta Title --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Meta Title

                        </label>

                        <input
                            type="text"
                            id="meta_title"
                            name="meta_title"
                            maxlength="60"
                            class="form-control @error('meta_title') is-invalid @enderror"
                            value="{{ old('meta_title') }}"
                            placeholder="SEO Meta Title">

                        @error('meta_title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="d-flex justify-content-between mt-1">

                            <small class="text-muted">

                                Recommended:
                                50 - 60 characters

                            </small>

                            <small>

                                <span id="metaTitleCount">

                                    0

                                </span>/60

                            </small>

                        </div>

                    </div>

                    {{-- Meta Description --}}
                    <div class="col-md-12 mb-4">

                        <label class="form-label">

                            Meta Description

                        </label>

                        <textarea
                            rows="5"
                            maxlength="160"
                            id="meta_description"
                            name="meta_description"
                            class="form-control @error('meta_description') is-invalid @enderror"
                            placeholder="SEO Meta Description">{{ old('meta_description') }}</textarea>

                        @error('meta_description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="d-flex justify-content-between mt-1">

                            <small class="text-muted">

                                Recommended:
                                150 - 160 characters

                            </small>

                            <small>

                                <span id="metaDescriptionCount">

                                    0

                                </span>/160

                            </small>

                        </div>

                    </div>

                    {{-- SEO Preview --}}
                    <div class="col-12">

                        <div class="card border border-success shadow-none">

                            <div class="card-header bg-label-success">

                                <h6 class="mb-0">

                                    <i class="ti ti-brand-google me-2"></i>

                                    Google Search Preview

                                </h6>

                            </div>

                            <div class="card-body">

                                <div
                                    id="seoPreviewTitle"
                                    class="fw-bold text-primary fs-5">

                                    Tour Title

                                </div>

                                <div class="text-success small mb-2">

                                    https://yourwebsite.com/tours/

                                    <span id="seoPreviewSlug">

                                        tour-slug

                                    </span>

                                </div>

                                <div
                                    id="seoPreviewDescription"
                                    class="text-muted">

                                    Your meta description will appear here...

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{------------- RIGHT SIDEBAR -------------}}
        <div class="col-lg-4">

            {{-- Publish --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Publish
                    </h5>
                </div>
                <div class="card-body">
                    {{-- =========================
                    PUBLISH
                    ========================= --}}
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
                                    {{ old('status',1) ? 'checked' : '' }}>

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
                                    {{ old('featured') ? 'checked' : '' }}>

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
                                    {{ old('popular') ? 'checked' : '' }}>

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
                                    value="{{ old('sort_order',0) }}">

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Destination --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Destination
                    </h5>
                </div>
                <div class="card-body">
                    {{-- =========================
                    DESTINATION
                    ========================= --}}
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
                                            {{ old('destination_id')==$destination->id ? 'selected':'' }}>

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
                                            {{ old('tour_category_id')==$category->id ? 'selected':'' }}>

                                            {{ $category->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Duration --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Duration
                    </h5>
                </div>
                <div class="card-body">
                    {{-- =========================
                    TOUR INFORMATION
                    ========================= --}}
                    <div class="card mb-4">

                        <div class="card-header">

                            <h5 class="mb-0">

                                <i class="ti ti-users me-2 text-warning"></i>

                                Tour Information

                            </h5>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-6">

                                    <div class="border rounded p-3 text-center">

                                        <small class="text-muted d-block">

                                            Days

                                        </small>

                                        <h5
                                            class="mb-0"
                                            id="daysPreview">

                                            0

                                        </h5>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="border rounded p-3 text-center">

                                        <small class="text-muted d-block">

                                            Nights

                                        </small>

                                        <h5
                                            class="mb-0"
                                            id="nightsPreview">

                                            0

                                        </h5>

                                    </div>

                                </div>

                                <div class="col-12 mt-3">

                                    <div class="border rounded p-3 text-center">

                                        <small class="text-muted d-block">

                                            Maximum People

                                        </small>

                                        <h5
                                            class="mb-0"
                                            id="peoplePreview">

                                            1

                                        </h5>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Featured Image
                    </h5>
                </div>
                <div class="card-body">
                    {{-- =========================
                    FEATURED IMAGE
                    ========================= --}}
                    <div class="card mb-4">

                        <div class="card-header">

                            <h5 class="mb-0">

                                <i class="ti ti-photo me-2 text-info"></i>

                                Featured Image

                            </h5>

                        </div>

                        <div class="card-body">

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

                            <div
                                class="border rounded mt-3 p-2 text-center">

                                <img
                                    src="{{ asset('admin/assets/img/illustrations/placeholder.jpg') }}"
                                    id="previewImage"
                                    class="img-fluid rounded"
                                    style="
                                        max-height:220px;
                                        object-fit:cover;
                                        width:100%;
                                    ">

                            </div>

                            <small class="text-muted d-block mt-2">

                                Recommended Size:
                                <strong>1200 × 800 px</strong>

                            </small>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-device-floppy me-1"></i>
                        Save Tour
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
    @include('admin.tours.create-script')
@endpush
