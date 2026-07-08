@extends('admin.layouts.app')
@section('title',$title)
    @section('content')
        {{--------------- HEADER ---------------}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    Add Tour Image
                </h4>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('tour_images.index') }}">
                                Tour Images
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Create
                        </li>
                    </ol>
                </nav>
            </div>

            <a href="{{ route('tour_images.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left"></i>
                Back
            </a>
        </div>

        <form action="{{ route('tour_images.store') }}" method="POST" enctype="multipart/form-data" id="tourImageForm">
            @csrf
            <div class="row">
                {{--------------- LEFT SIDE ---------------}}
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                Basic Information
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                {{-- Tour --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label"> Tour <span class="text-danger">*</span>
                                    </label>

                                    <select name="tour_id" class="form-select select2 @error('tour_id') is-invalid @enderror">
                                        <option value="">
                                            Select Tour
                                        </option>

                                        @foreach($tours as $tour)
                                            <option value="{{ $tour->id }}" {{ old('tour_id')==$tour->id ? 'selected' : '' }}>
                                                {{ $tour->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('tour_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Title --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Image Title</label>

                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        class="form-control" placeholder="Image Title">
                                </div>

                                {{-- Caption --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Caption</label>

                                    <textarea name="caption" id="caption" rows="4" class="form-control"
                                        placeholder="Image Caption">{{ old('caption') }}</textarea>
                                </div>

                                {{-- Sort --}}
                                <div class="col-md-6">
                                    <label class="form-label">Sort Order</label>

                                    <input type="number" name="sort_order" class="form-control"
                                        value="{{ old('sort_order',0) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--------------- SIDEBAR ---------------}}
                <div class="col-lg-4">
                    {{-- Status --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                Settings
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="status" value="1" checked>
                                <label class="form-check-label">
                                    Active
                                </label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="featured" value="1">
                                <label class="form-check-label">
                                    Featured Image
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Upload --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                Upload Images
                            </h5>
                        </div>

                        <div class="card-body">
                            <img id="previewImage" src="{{ asset('admin/assets/img/illustrations/placeholder.jpg') }}"
                                class="img-fluid rounded border mb-3" style="width:100%;height:240px;object-fit:cover;">

                            <input type="file" id="image" name="images[]" multiple
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/*">
                            @error('images')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted mt-2 d-block"> JPG, PNG, WEBP (Max: 2MB)</small>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i>
                                    Save Image
                                </button>

                                <a href="{{ route('tour_images.index') }}" class="btn btn-outline-secondary">
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
    @include('admin.tour_images.scripts')
@endpush
