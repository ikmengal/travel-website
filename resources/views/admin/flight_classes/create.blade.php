@extends('admin.layouts.app')
@section('title','Create Flight Class')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Create Flight Class
            </h4>
            <p class="text-muted mb-0">
                Add a new flight class.
            </p>
        </div>

        <a href="{{ route('flight_classes.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>

    <form id="flightClassForm" enctype="multipart/form-data">
        @csrf
        @include('admin.flight_classes.partials.form')
    </form>
@endsection
@push('js')
    @include('admin.flight_classes.partials.form_create_script')
@endpush
