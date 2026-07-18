@extends('admin.layouts.app')
@section('title', $title)
@section('content')
<form id="testimonialForm" action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-plus text-primary me-2"></i>
                Create Testimonial
            </h4>

            <p class="text-muted mb-0">
                Add a new testimonial.
            </p>
        </div>

        <a href="{{ route('testimonials.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>
    @include('admin.testimonials.form')
</form>
@endsection
@push('js')
    @include('admin.testimonials.partials.create-script')
@endpush
