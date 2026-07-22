@extends('admin.layouts.app')
@section('title', 'Edit Gallery')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    Edit Gallery
                </h4>
                <small class="text-muted">
                    Update gallery image details.
                </small>
            </div>
            <a href="{{ route('gallery.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>

        <div class="card-body">
            <form id="galleryForm" action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.gallery.partials.form')
                <hr>

                <div class="text-end">
                    <button type="submit" id="submitBtn" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>
                        Update Gallery
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.gallery.partials.scripts-create')
@endpush
