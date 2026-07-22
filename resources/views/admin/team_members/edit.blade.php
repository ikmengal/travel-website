@extends('admin.layouts.app')
@section('title', 'Edit Team Member')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">
                Edit Team Member
            </h4>
            <small class="text-muted">
                Update team member information.
            </small>
        </div>

        <a href="{{ route('team_members.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>
    <div class="card-body">
        <form id="teamMemberForm" action="{{ route('team_members.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.team_members.partials.form')
        </form>
    </div>
</div>
@endsection
@push('js')
    @include('admin.team_members.partials.scripts-create')
@endpush
