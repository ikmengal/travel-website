@extends('admin.layouts.app')

@section('title', 'Edit Airline')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                Edit Airline

            </h4>

            <p class="text-muted mb-0">

                Update airline information.

            </p>

        </div>

        <div>

            @can('airlines-view')

                <a href="{{ route('airlines.show',$airline->id) }}"
                    class="btn btn-label-info">

                    <i class="ti ti-eye me-1"></i>

                    View

                </a>

            @endcan

            <a href="{{ route('airlines.index') }}"
                class="btn btn-label-secondary">

                <i class="ti ti-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <form
        id="airlineForm"
        enctype="multipart/form-data">

        @csrf

        @method('PUT')

        @include('admin.airlines.partials.form')

    </form>

</div>

@endsection
@push('js')
    @include('admin.airlines.scripts')
@endpush
