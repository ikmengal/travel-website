@extends('admin.layouts.app')

@section('title',$title)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h4 class="fw-bold mb-1">

            Tour Include Details

        </h4>

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb mb-0">

                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('tour_includes.index') }}">
                        Tour Includes
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    Details
                </li>

            </ol>

        </nav>

    </div>

    <div class="d-flex gap-2">

        @can('tour-includes-edit')
            <a href="{{ route('tour_includes.edit',$tourInclude->id) }}"
                class="btn btn-primary">

                <i class="ti ti-edit me-1"></i>

                Edit

            </a>
        @endcan

        <a href="{{ route('tour_includes.index') }}"
            class="btn btn-outline-secondary">

            <i class="ti ti-arrow-left me-1"></i>

            Back

        </a>

    </div>

</div>

<div class="row">

    {{-- ===================================== --}}
    {{-- LEFT --}}
    {{-- ===================================== --}}

    <div class="col-lg-8">

        <div class="card mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    Include Information

                </h5>

            </div>

            <div class="card-body">

                <table class="table table-borderless">

                    <tr>

                        <th width="220">

                            Tour

                        </th>

                        <td>

                            {{ $tourInclude->tour->title ?? '-' }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Include Title

                        </th>

                        <td>

                            {{ $tourInclude->title }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Icon

                        </th>

                        <td>

                            <span class="badge bg-label-primary me-2">

                                {{ $tourInclude->icon }}

                            </span>

                            <i class="{{ $tourInclude->icon }} fs-3"></i>

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Sort Order

                        </th>

                        <td>

                            {{ $tourInclude->sort_order }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Status

                        </th>

                        <td>

                            @if($tourInclude->status)

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

                        <th>

                            Created At

                        </th>

                        <td>

                            {{ $tourInclude->created_at->format('d M Y h:i A') }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Updated At

                        </th>

                        <td>

                            {{ $tourInclude->updated_at->format('d M Y h:i A') }}

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

    {{-- ===================================== --}}
    {{-- RIGHT --}}
    {{-- ===================================== --}}

    <div class="col-lg-4">

        {{-- Icon Preview --}}
        <div class="card mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    Icon Preview

                </h5>

            </div>

            <div class="card-body text-center py-5">

                <div class="display-2 mb-3">

                    <i class="{{ $tourInclude->icon }}"></i>

                </div>

                <h5>

                    {{ $tourInclude->title }}

                </h5>

                <small class="text-muted">

                    {{ $tourInclude->icon }}

                </small>

            </div>

        </div>

        {{-- Quick Info --}}
        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    Quick Information

                </h5>

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <small class="text-muted d-block">

                        Tour

                    </small>

                    <strong>

                        {{ $tourInclude->tour->title ?? '-' }}

                    </strong>

                </div>

                <hr>

                <div class="mb-3">

                    <small class="text-muted d-block">

                        Sort Order

                    </small>

                    <span class="badge bg-label-info">

                        {{ $tourInclude->sort_order }}

                    </span>

                </div>

                <hr>

                <div class="mb-3">

                    <small class="text-muted d-block">

                        Status

                    </small>

                    @if($tourInclude->status)

                        <span class="badge bg-success">

                            Active

                        </span>

                    @else

                        <span class="badge bg-danger">

                            Inactive

                        </span>

                    @endif

                </div>

                <hr>

                <div>

                    <small class="text-muted d-block">

                        Created

                    </small>

                    {{ $tourInclude->created_at->diffForHumans() }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
