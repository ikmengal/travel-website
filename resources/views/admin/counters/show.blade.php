@extends('admin.layouts.app')
@section('title', 'Counter Details')
@section('content')
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">
                            Counter Details
                        </h4>
                        <small class="text-muted">
                            View homepage counter information.
                        </small>
                    </div>
                    <div>
                        @can('counters-edit')
                            <a href="{{ route('counters.edit', $counter->id) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>
                                Edit
                            </a>
                        @endcan
                        <a href="{{ route('counters.index') }}" class="btn btn-label-secondary">
                            <i class="ti ti-arrow-left me-1"></i>
                            Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- Icon Preview --}}
                        <div class="col-md-4">
                            <div class="border rounded text-center p-5">
                                <i class="{{ $counter->icon }}" style="font-size:80px;"></i>
                                <h5 class="mt-4 mb-0">
                                    {{ $counter->title }}
                                </h5>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="col-md-8">
                            <table class="table table-bordered align-middle">
                                <tbody>
                                    <tr>
                                        <th width="220">Icon</th>
                                        <td>
                                            <code>{{ $counter->icon }}</code>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{ $counter->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Prefix</th>
                                        <td>{{ $counter->prefix ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Number</th>
                                        <td>{{ number_format($counter->number) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Suffix</th>
                                        <td>{{ $counter->suffix ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Preview</th>
                                        <td>
                                            <span class="badge bg-label-primary fs-6">
                                                {{ $counter->prefix }}{{ number_format($counter->number) }}{{ $counter->suffix }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{!! $counter->description ?: '<span class="text-muted">N/A</span>' !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Sort Order</th>
                                        <td>{{ $counter->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($counter->status)
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
                                        <th>Created At</th>
                                        <td>{{ $counter->created_at->format('d M Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $counter->updated_at->format('d M Y h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
