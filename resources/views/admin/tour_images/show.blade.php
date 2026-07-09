@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Tour Image Details
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('tour_images.index') }}">
                            Tour Images
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Details
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('tour_images.edit',$image->id) }}" class="btn btn-warning">
                <i class="ti ti-edit"></i>
                Edit
            </a>

            <a href="{{ route('tour_images.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-------------- IMAGE PREVIEW --------------}}
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Image Preview
                    </h5>
                </div>

                <div class="card-body">
                    <img src="{{ asset('images/gallery/'.$image->image) }}" class="img-fluid rounded shadow border" style="width:100%;height:450px;object-fit:cover;">
                </div>
            </div>
        </div>

        {{-------------- DETAILS --------------}}
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Image Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="220">Tour</th>
                            <td>
                                {{ $image->tour->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>Image Title</th>
                            <td>
                                {{ $image->title ?: '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Caption</th>
                            <td>
                                {{ $image->caption ?: '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Sort Order</th>
                            <td>
                                {{ $image->sort_order }}
                            </td>
                        </tr>
                        <tr>
                            <th>Featured</th>
                            <td>
                                @if($image->featured)
                                    <span class="badge bg-warning">
                                        Featured
                                    </span>
                                @else
                                    <span class="badge bg-label-secondary">
                                        No
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($image->status)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $image->created_at->format('d M Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $image->updated_at->format('d M Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Quick Actions
                    </h5>
                </div>

                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('tour_images.edit',$image->id) }}" class="btn btn-warning">
                            <i class="ti ti-edit"></i>
                            Edit
                        </a>
                        <a href="{{ asset('images/gallery/'.$image->image) }}" target="_blank" class="btn btn-info">
                            <i class="ti ti-photo"></i>
                            Full Image
                        </a>
                        <a href="{{ route('tour_images.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-list"></i>
                            All Images
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
