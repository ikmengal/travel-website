@extends('admin.layouts.app')
@section('title','Edit Counter')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h4>Edit Counter</h4>
                        <small>Update counter</small>
                    </div>
                    <a href="{{ route('counters.index') }}" class="btn btn-label-secondary">
                        <i class="ti ti-arrow-left"></i>
                        Back
                    </a>
                </div>
                <div class="card-body">
                    @include('admin.counters._form')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.counters.partials.create_edit-scripts')
@endpush
