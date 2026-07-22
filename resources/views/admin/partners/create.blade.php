@extends('admin.layouts.app')
@section('title', 'Add Partner')
@section('content')
<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Add Partner</h4>
                    <small class="text-muted">
                        Create a new partner / brand.
                    </small>
                </div>
                <a href="{{ route('partners.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back
                </a>
            </div>

            <div class="card-body">
                <form id="partnerForm" action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.partners._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    @include('admin.partners.partials.create_edit_script')
@endpush
