@extends('admin.layouts.app')
@section('title', $title)
@section('content')
<form id="testimonialForm" action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-edit text-warning me-2"></i>
                Edit Testimonial
            </h4>
            <p class="text-muted mb-0">
                Update testimonial information.
            </p>
        </div>
        <div class="d-flex gap-2">
            @can('testimonials-view')
                <a href="{{ route('testimonials.show', $testimonial->id) }}" class="btn btn-label-info">
                    <i class="ti ti-eye me-1"></i>
                    View
                </a>
            @endcan
            <a href="{{ route('testimonials.index') }}"class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>
    {{-- Reusable Form --}}
    @include('admin.testimonials.form')
</form>
@endsection
@push('js')
    @include('admin.testimonials.partials.create-script')
@endpush
