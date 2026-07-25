@extends('admin.layouts.app')

@section('title', 'Create Airline')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Create Airline
            </h4>

            <p class="text-muted mb-0">
                Add a new airline to your travel management system.
            </p>
        </div>

        <a href="{{ route('airlines.index') }}"
            class="btn btn-label-secondary">

            <i class="ti ti-arrow-left me-1"></i>

            Back

        </a>

    </div>

    <form
        id="airlineForm"
        enctype="multipart/form-data">

        @csrf

        @include('admin.airlines.partials.form')

    </form>
@endsection
@push('js')
    @include('admin.airlines.partials.create_scripts')
@endpush
