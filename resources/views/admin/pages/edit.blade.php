@extends('admin.layouts.app')
@section('title', 'Edit Page')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Edit Page
            </h4>
            <p class="text-muted mb-0">
                Update page information.
            </p>
        </div>

        <a href="{{ route('pages.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>

    <form id="pageForm" action="{{ route('pages.update',$page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.pages._form',['page'=>$page])
    </form>
</div>
@endsection
@push('js')
    @include('admin.pages.partials.create_edit_scripts')
@endpush
