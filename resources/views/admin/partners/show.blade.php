@extends('admin.layouts.app')
@section('title', 'Partner Details')
@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">
                            Partner Details
                        </h4>
                        <small class="text-muted">
                            View partner / brand information.
                        </small>
                    </div>
                    <div>
                        @can('partners-edit')
                            <a href="{{ route('partners.edit', $partner->id) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>
                                Edit
                            </a>
                        @endcan
                        <a href="{{ route('partners.index') }}" class="btn btn-label-secondary">
                            <i class="ti ti-arrow-left me-1"></i>
                            Back
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Logo --}}
                        <div class="col-md-4 text-center">

                            <img src="{{ $partner->logo }}"
                                class="img-fluid rounded border p-2"
                                style="max-height:220px; object-fit:contain;"
                                alt="{{ $partner->name }}">

                        </div>

                        {{-- Details --}}
                        <div class="col-md-8">

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>

                                        <th width="220">
                                            Partner Name
                                        </th>

                                        <td>
                                            {{ $partner->name }}
                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Website
                                        </th>

                                        <td>

                                            @if($partner->website)

                                                <a href="{{ $partner->website }}"
                                                    target="_blank">

                                                    {{ $partner->website }}

                                                </a>

                                            @else

                                                —

                                            @endif

                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Sort Order
                                        </th>

                                        <td>

                                            {{ $partner->sort_order }}

                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Featured
                                        </th>

                                        <td>

                                            @if($partner->featured)

                                                <span class="badge bg-label-success">

                                                    Yes

                                                </span>

                                            @else

                                                <span class="badge bg-label-secondary">

                                                    No

                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Status
                                        </th>

                                        <td>

                                            @if($partner->status)

                                                <span class="badge bg-label-success">

                                                    Active

                                                </span>

                                            @else

                                                <span class="badge bg-label-danger">

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

                                            {{ $partner->created_at->format('d M Y h:i A') }}

                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Updated At
                                        </th>

                                        <td>

                                            {{ $partner->updated_at->format('d M Y h:i A') }}

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
