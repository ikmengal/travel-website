@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 mx-2">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-user-plus me-2"></i>
                Edit User
            </h4>
            <p class="text-muted mb-0">
                Edit a system user and assign a role.
            </p>
        </div>

        <div>
            <a href="{{ route('users.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>
    <form action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.users._form')
    </form>
@endsection
@push('js')
    <script src="{{ asset('admin/assets/js/users.js') }}"></script>
@endpush
