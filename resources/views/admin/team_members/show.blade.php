@extends('admin.layouts.app')
@section('title', 'Team Member Details')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">
                    Team Member Details
                </h4>
                <small class="text-muted">
                    View team member information.
                </small>
            </div>

            <div>
                @can('team-members-edit')
                    <a href="{{ route('team_members.edit', $teamMember->id) }}" class="btn btn-primary">
                        <i class="ti ti-edit me-1"></i>
                        Edit
                    </a>
                @endcan
                <a href="{{ route('team_members.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Left Side --}}
                <div class="col-lg-4">
                    <div class="card border shadow-none">
                        <div class="card-body text-center">
                            <img src="{{ $teamMember->image }}" class="rounded-circle border mb-3"
                                style="width:180px;height:180px;object-fit:cover;">
                            <h4 class="mb-1">
                                {{ $teamMember->name }}
                            </h4>
                            <p class="text-muted mb-3">
                                {{ $teamMember->designation }}
                            </p>
                            @if($teamMember->featured)
                                <span class="badge bg-label-warning">
                                    Featured Member
                                </span>
                            @endif
                            <div class="mt-3">
                                @if($teamMember->status)
                                    <span class="badge bg-label-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-label-danger">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side --}}
                <div class="col-lg-8">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th width="220">Full Name</th>
                                <td>{{ $teamMember->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td><code>{{ $teamMember->slug }}</code></td>
                            </tr>
                            <tr>
                                <th>Designation</th>
                                <td>{{ $teamMember->designation }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $teamMember->email ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $teamMember->phone ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>Sort Order</th>
                                <td>{{ $teamMember->sort_order }}</td>
                            </tr>
                            <tr>
                                <th>Short Bio</th>
                                <td>{!! $teamMember->short_bio ?: '<span class="text-muted">N/A</span>' !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            {{-- Social Media --}}
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">
                        Social Media
                    </h5>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="180">Facebook</th>
                                <td>
                                    @if($teamMember->facebook)
                                        <a href="{{ $teamMember->facebook }}" target="_blank">
                                            {{ $teamMember->facebook }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Instagram</th>
                                <td>
                                    @if($teamMember->instagram)
                                        <a href="{{ $teamMember->instagram }}" target="_blank">
                                            {{ $teamMember->instagram }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>LinkedIn</th>
                                <td>
                                    @if($teamMember->linkedin)
                                        <a href="{{ $teamMember->linkedin }}" target="_blank">
                                            {{ $teamMember->linkedin }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="180">Twitter (X)</th>
                                <td>
                                    @if($teamMember->twitter)
                                        <a href="{{ $teamMember->twitter }}" target="_blank">
                                            {{ $teamMember->twitter }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>YouTube</th>
                                <td>
                                    @if($teamMember->youtube)
                                        <a href="{{ $teamMember->youtube }}" target="_blank">
                                            {{ $teamMember->youtube }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $teamMember->created_at->format('d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $teamMember->updated_at->format('d M Y h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
