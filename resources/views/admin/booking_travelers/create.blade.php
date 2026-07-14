@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">
                <i class="ti ti-user-plus ti-md me-2 text-primary"></i>
                Add Booking Traveler
            </h4>
            <p class="text-muted mb-0">
                Create a new traveler for an existing booking.
            </p>
        </div>
        <div>
            <a href="{{ route('booking_travelers.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <form action="{{ route('booking_travelers.store') }}" method="POST" id="travelerForm">
        @csrf

        <div class="row">
            {{------------- Left Side -------------}}
            <div class="col-lg-8">
                {{-- Booking Information --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Booking Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Booking <span class="text-danger">*</span></label>
                                <select name="booking_id" id="booking_id" class="form-select select2 @error('booking_id') is-invalid @enderror">
                                    <option value="">
                                        Select Booking
                                    </option>

                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                            {{ $booking->booking_no }}
                                            -
                                            {{ $booking->user->name ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('booking_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Customer</label>
                                <input type="text" id="customer_name" class="form-control"readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tour</label>
                                <input type="text" id="tour_name" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{------------- Traveler Information -------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Traveler Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                                    value="{{ old('full_name') }}" placeholder="Enter traveler full name">

                                @error('full_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select select2 @error('gender') is-invalid @enderror">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                        Male
                                    </option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                        Female
                                    </option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                                        Other
                                    </option>
                                </select>

                                @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                                    value="{{ old('date_of_birth') }}">

                                @error('date_of_birth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nationality</label>

                                <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror"
                                    value="{{ old('nationality') }}" placeholder="e.g. Pakistan">

                                @error('nationality')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">CNIC</label>

                                <input type="text" name="cnic" class="form-control @error('cnic') is-invalid @enderror"
                                    value="{{ old('cnic') }}" placeholder="xxxxx-xxxxxxx-x">

                                @error('cnic')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{------------- Passport Information -------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Passport Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Passport No</label>
                                <input type="text" name="passport_no" class="form-control @error('passport_no') is-invalid @enderror"
                                    value="{{ old('passport_no') }}" placeholder="Passport Number">

                                @error('passport_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Passport Expiry</label>

                                <input type="date" name="passport_expiry"
                                    class="form-control @error('passport_expiry') is-invalid @enderror"
                                    value="{{ old('passport_expiry') }}">

                                @error('passport_expiry')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>

                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="Email Address">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="Phone Number">

                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact Name</label>

                                <input type="text" name="emergency_contact_name" class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                    value="{{ old('emergency_contact_name') }}" placeholder="Emergency Contact Name">

                                @error('emergency_contact_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact Phone</label>

                                <input type="text" name="emergency_contact_phone"
                                    class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                    value="{{ old('emergency_contact_phone') }}" placeholder="Emergency Contact Phone">

                                @error('emergency_contact_phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Address</label>

                                <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter Address">{{ old('address') }}</textarea>

                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Notes</label>

                                <textarea name="notes" id="notes" rows="5"
                                    class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>

                                @error('notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{------------- Right Sidebar -------------}}
            <div class="col-lg-4">
                {{-- Publish --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Publish
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" value="1" checked>
                                <label class="form-check-label">Active Traveler</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save Traveler
                            </button>

                            <a href="{{ route('booking_travelers.index') }}" class="btn btn-label-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    @include('admin.booking_travelers.create-script')
@endpush
