@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{------------- Page Header -------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-user-circle ti-md me-2 text-primary"></i>
                Traveler Details
            </h4>
            <p class="text-muted mb-0">
                Complete traveler profile and booking information.
            </p>
        </div>

        <div>
            @can('booking-travelers-edit')
                <a href="{{ route('booking_travelers.edit',$traveler->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan
            <a href="{{ route('booking_travelers.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{------------- Left -------------}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            {{ strtoupper(substr($traveler->first_name,0,1)) }}
                        </span>
                    </div>
                    <h4>
                        {{ $traveler->first_name }}
                    </h4>
                    <p class="text-muted">
                        {{ ucfirst($traveler->gender) }}
                    </p>

                    <hr>

                    <table class="table table-borderless text-start">
                        <tr>
                            <th width="45%">Booking #</th>
                            <td>
                                {{ $traveler->booking->booking_no }}
                            </td>
                        </tr>

                        <tr>
                            <th>Customer</th>
                            <td>
                                {{ $traveler->booking->user->name ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Tour</th>
                            <td>
                                {{ $traveler->booking->tour->title ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                {!! statusBadge($traveler->status) !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Timeline
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Created</th>
                            <td>
                                {{ $traveler->created_at->format('d M Y h:i A') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Updated</th>
                            <td>
                                {{ $traveler->updated_at->format('d M Y h:i A') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-----------  Right -------------}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Personal Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Full Name</label>
                            <p>
                                {{ $traveler->full_name }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Gender</label>
                            <p>
                                {{ ucfirst($traveler->gender) }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Date of Birth</label>
                            <p>
                                {{ optional($traveler->date_of_birth)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Nationality</label>
                            <p>
                                {{ $traveler->nationality ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">CNIC</label>
                            <p>
                                {{ $traveler->cnic ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Email</label>
                            <p>
                                {{ $traveler->email ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Phone</label>
                            <p>
                                {{ $traveler->phone ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Passport Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-semibold">Passport No</label>
                            <p>
                                {{ $traveler->passport_number ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold">Passport Expiry</label>
                            <p>
                                {{ optional($traveler->passport_expiry)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Emergency Contact
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-semibold">Contact Name</label>
                            <p>
                                {{ $traveler->emergency_contact_name ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold">Contact Phone</label>
                            <p>
                                {{ $traveler->emergency_contact_phone ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Address & Notes
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <label class="fw-semibold">Address</label>
                        <p>
                            {{ $traveler->address ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="fw-semibold">Notes</label>
                        <div>
                            {!! $traveler->notes !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
