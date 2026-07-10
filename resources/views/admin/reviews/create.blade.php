@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{--------------- PAGE HEADER ---------------}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-plus text-primary me-2"></i>
                Add New Review
            </h4>
            <p class="text-muted mb-0">
                Create customer reviews for Tours, Hotels, Destinations, Flights and Cars.
            </p>
        </div>

        <div>
            <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    {{--------------- FORM ---------------}}
    <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
        @csrf
        <div class="row">
            {{--------------- LEFT SIDE ---------------}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Review Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Review Type --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Review Type <span class="text-danger">*</span></label>
                                <select name="reviewable_type" id="reviewable_type"
                                    class="form-select select2 @error('reviewable_type') is-invalid @enderror">

                                    <option value="">Select Type</option>
                                    <option value="App\Models\Tour">Tour</option>
                                    <option value="App\Models\Hotel">Hotel</option>
                                    <option value="App\Models\Destination">Destination</option>
                                    <option value="App\Models\Car">Car</option>
                                    <option value="App\Models\Flight">Flight</option>
                                    {{-- <option value="App\Models\TourPackage">Tour Package</option> --}}
                                </select>

                                @error('reviewable_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Related Item --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Related Item <span class="text-danger">*</span></label>

                                <select name="reviewable_id" id="reviewable_id"
                                    class="form-select select2 @error('reviewable_id') is-invalid @enderror">
                                    <option value="">Select Item</option>
                                </select>

                                @error('reviewable_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Customer --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Customer <span class="text-danger">*</span></label>
                                <select name="user_id" id="user_id"
                                    class="form-select select2 @error('user_id') is-invalid @enderror">

                                    <option value="">Select Customer</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                            ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Booking --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Booking <small class="text-muted">(Optional)</small></label>
                                <select name="booking_id" id="booking_id" class="form-select select2">
                                    <option value="">Select Booking</option>
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                            #{{ $booking->id }}
                                            @if(isset($booking->booking_number))
                                                - {{ $booking->booking_number }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Rating --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>

                                <select name="rating" class="form-select select2 @error('rating') is-invalid @enderror">
                                    <option value="">Select Rating</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}"
                                            {{ old('rating') == $i ? 'selected' : '' }}>
                                            {{ str_repeat('⭐', $i) }}
                                            ({{ $i }} Star{{ $i > 1 ? 's' : '' }})
                                        </option>
                                    @endfor
                                </select>

                                @error('rating')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Title --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Review Title</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Amazing Experience">

                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Review --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Review <span class="text-danger">*</span></label>
                                <textarea name="review" id="review" rows="8"
                                    class="form-control @error('review') is-invalid @enderror">{{ old('review') }}</textarea>

                                @error('review')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pros --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pros</label>
                                <textarea name="pros" rows="5" class="form-control @error('pros') is-invalid @enderror"
                                    placeholder="Friendly staff, Clean rooms, Beautiful view...">{{ old('pros') }}</textarea>

                                @error('pros')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Cons --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cons</label>
                                <textarea name="cons" rows="5" class="form-control @error('cons') is-invalid @enderror"
                                    placeholder="Slow WiFi, Small parking area...">{{ old('cons') }}</textarea>

                                @error('cons')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{---------------  RIGHT SIDEBAR ---------------}}
            <div class="col-lg-4">
                {{-- Review Settings --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Review Settings
                        </h5>
                    </div>

                    <div class="card-body">
                        {{-- Verified --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified"
                                value="1" {{ old('is_verified') ? 'checked' : '' }}>

                            <label class="form-check-label" for="is_verified">
                                Verified Review
                            </label>
                        </div>

                        {{-- Featured --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                value="1" {{ old('is_featured') ? 'checked' : '' }}>

                            <label class="form-check-label" for="is_featured">
                                Featured Review
                            </label>
                        </div>

                        {{-- Status --}}
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status"
                                value="1" {{ old('status',1) ? 'checked' : '' }}>

                            <label class="form-check-label" for="status">
                                Approved
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Approval --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Approval
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Approved At</label>

                            <input type="datetime-local" name="approved_at" class="form-control" value="{{ old('approved_at') }}">
                            <small class="text-muted">
                                Leave empty if review is not approved yet.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save Review
                            </button>

                            <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary">
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
    @include('admin.reviews.create-script')
@endpush
