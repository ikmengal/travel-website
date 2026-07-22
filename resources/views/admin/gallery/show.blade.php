@extends('admin.layouts.app')
@section('title','Gallery Details')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                Gallery Details
            </h4>
            <a href="{{ route('gallery.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $gallery->image }}" class="img-fluid rounded shadow border">
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Title</th>
                            <td>{{ $gallery->title }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $gallery->slug }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $gallery->category ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Caption</th>
                            <td>{{ $gallery->caption ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Featured</th>
                            <td>
                                {!! $gallery->featured
                                    ? '<span class="badge bg-success">Yes</span>'
                                    : '<span class="badge bg-secondary">No</span>' !!}
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                {!! $gallery->status
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-danger">Inactive</span>' !!}
                            </td>
                        </tr>
                        <tr>
                            <th>Sort Order</th>
                            <td>{{ $gallery->sort_order }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $gallery->created_at->format('d M Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-12 mt-4">
                    <h5>Description</h5>
                    <hr>
                    {!! $gallery->description ?: '<span class="text-muted">No description available.</span>' !!}
                </div>
            </div>
        </div>
    </div>
@endsection
