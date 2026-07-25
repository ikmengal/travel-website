@extends('admin.layouts.app')

@section('title', 'Airline Details')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Airline Details
            </h4>

            <p class="text-muted mb-0">
                View complete airline information.
            </p>
        </div>

        <div>

            @can('airlines-edit')
                <a href="{{ route('airlines.edit',$airline->id) }}"
                    class="btn btn-primary">

                    <i class="ti ti-edit me-1"></i>

                    Edit

                </a>
            @endcan

            <a href="{{ route('airlines.index') }}"
                class="btn btn-label-secondary">

                <i class="ti ti-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <div class="row">

        {{-- Left Side --}}
        <div class="col-lg-8">

            {{-- Basic Information --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Basic Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>
                            <th width="220">Airline Name</th>
                            <td>{{ $airline->name }}</td>
                        </tr>

                        <tr>
                            <th>Slug</th>
                            <td>{{ $airline->slug }}</td>
                        </tr>

                        <tr>
                            <th>IATA Code</th>
                            <td>
                                <span class="badge bg-label-primary">
                                    {{ $airline->iata_code ?: '-' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>ICAO Code</th>
                            <td>
                                <span class="badge bg-label-info">
                                    {{ $airline->icao_code ?: '-' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Airline Code</th>
                            <td>
                                <span class="badge bg-label-dark">
                                    {{ $airline->airline_code }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Website</th>
                            <td>

                                @if($airline->website)

                                    <a href="{{ $airline->website }}"
                                        target="_blank">

                                        {{ $airline->website }}

                                    </a>

                                @else

                                    -

                                @endif

                            </td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td>{{ $airline->email ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td>{{ $airline->phone ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Sort Order</th>
                            <td>{{ $airline->sort_order }}</td>
                        </tr>

                        <tr>

                            <th>Status</th>

                            <td>

                                @if($airline->status)

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

                            <th>Featured</th>

                            <td>

                                @if($airline->featured)

                                    <span class="badge bg-warning">

                                        Featured

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            {{-- Description --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Description

                    </h5>

                </div>

                <div class="card-body">

                    @if($airline->description)

                        {!! $airline->description !!}

                    @else

                        <span class="text-muted">

                            No description available.

                        </span>

                    @endif

                </div>

            </div>

            {{-- SEO --}}
            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">

                        SEO Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="180">

                                Meta Title

                            </th>

                            <td>

                                {{ $airline->meta_title ?: '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Meta Description

                            </th>

                            <td>

                                {{ $airline->meta_description ?: '-' }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

        {{-- Right Side --}}
        <div class="col-lg-4">

            {{-- Logo --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Airline Logo

                    </h5>

                </div>

                <div class="card-body text-center">

                    @if($airline->logo)

                        <img
                            src="{{ asset('images/airlines/'.$airline->logo) }}"
                            class="img-fluid rounded border shadow-sm">

                    @else

                        <img
                            src="{{ asset('admin/assets/img/placeholder.jpg') }}"
                            class="img-fluid rounded border">

                    @endif

                </div>

            </div>

            {{-- Contact Card --}}
            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Contact Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <strong>Email</strong>

                        <br>

                        <span class="text-muted">

                            {{ $airline->email ?: 'N/A' }}

                        </span>

                    </div>

                    <div class="mb-3">

                        <strong>Phone</strong>

                        <br>

                        <span class="text-muted">

                            {{ $airline->phone ?: 'N/A' }}

                        </span>

                    </div>

                    <div>

                        <strong>Website</strong>

                        <br>

                        @if($airline->website)

                            <a href="{{ $airline->website }}"
                                target="_blank">

                                Visit Website

                            </a>

                        @else

                            <span class="text-muted">

                                N/A

                            </span>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Information --}}
            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">

                        Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="120">

                                Created

                            </th>

                            <td>

                                {{ $airline->created_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Updated

                            </th>

                            <td>

                                {{ $airline->updated_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
