@extends('admin.layouts.app')
@section('title', 'Create Page')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                Create Page

            </h4>

            <p class="text-muted mb-0">

                Create a new CMS page.

            </p>

        </div>

        <a href="{{ route('pages.index') }}"
            class="btn btn-label-secondary">

            <i class="ti ti-arrow-left me-1"></i>

            Back

        </a>

    </div>

    <form id="pageForm" action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.pages._form')
    </form>
@endsection
@push('js')
    @include('admin.pages.partials.create_edit_scripts')
@endpush
