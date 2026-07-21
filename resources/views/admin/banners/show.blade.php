@extends('admin.layouts.app')
@section('title', 'Banner Details')
@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">
                Banners /
            </span>
            Details
        </h4>

        <div>
            <a href="{{ route('banners.edit',$banner->id) }}" class="btn btn-primary me-2">
                <i class="ti ti-edit"></i>
                Edit
            </a>
            <a href="{{ route('banners.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Left Side --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Banner Image
                    </h5>
                </div>

                <div class="card-body text-center">
                    @if($banner->image)
                        <img src="{{ asset('images/banners/'.$banner->image) }}" class="img-fluid rounded border" style="max-height:250px;">
                    @else
                        <img src="{{ asset('admin/assets/img/no-image.png') }}" class="img-fluid rounded border" style="max-height:250px;">
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Side --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Banner Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Title</th>
                            <td>{{ $banner->title }}</td>
                        </tr>
                        <tr>
                            <th>Subtitle</th>
                            <td>{{ $banner->subtitle ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!! $banner->description ?? '-' !!}</td>
                        </tr>
                        <tr>
                            <th>Button Text</th>
                            <td>{{ $banner->button_text ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Button URL</th>
                            <td>
                                @if($banner->button_url)
                                    <a href="{{ $banner->button_url }}" target="_blank">
                                        {{ $banner->button_url }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Featured</th>
                            <td>
                                @if($banner->featured)
                                    <span class="badge bg-success">
                                        Featured
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        No
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($banner->status)
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
                            <th>Sort Order</th>
                            <td>{{ $banner->sort_order }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SEO Section --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                SEO Information
            </h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Meta Title</th>
                    <td>{{ $banner->meta_title ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Meta Description</th>
                    <td>{{ $banner->meta_description ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
