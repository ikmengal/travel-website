@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{--------------- PAGE HEADER ---------------}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                <i class="ti ti-edit text-warning me-2"></i>

                Edit Review

            </h4>

            <p class="text-muted mb-0">

                Update customer review information.

            </p>

        </div>

        <div>

            <a href="{{ route('reviews.index') }}"
                class="btn btn-outline-secondary">

                <i class="ti ti-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    {{--------------- FORM ---------------}}
    <form action="{{ route('reviews.update',$review->id) }}" method="POST" id="reviewForm">
        @csrf
        @method('PUT')

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

                                <label class="form-label">

                                    Review Type
                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="reviewable_type"
                                    id="reviewable_type"
                                    class="form-select select2 @error('reviewable_type') is-invalid @enderror">

                                    <option value="">Select Type</option>

                                    <option value="App\Models\Tour"
                                        {{ old('reviewable_type',$review->reviewable_type)==App\Models\Tour::class ? 'selected':'' }}>
                                        Tour
                                    </option>

                                    <option value="App\Models\Hotel"
                                        {{ old('reviewable_type',$review->reviewable_type)==App\Models\Hotel::class ? 'selected':'' }}>
                                        Hotel
                                    </option>

                                    <option value="App\Models\Destination"
                                        {{ old('reviewable_type',$review->reviewable_type)==App\Models\Destination::class ? 'selected':'' }}>
                                        Destination
                                    </option>

                                    <option value="App\Models\Car"
                                        {{ old('reviewable_type',$review->reviewable_type)==App\Models\Car::class ? 'selected':'' }}>
                                        Car
                                    </option>

                                    <option value="App\Models\Flight"
                                        {{ old('reviewable_type',$review->reviewable_type)==App\Models\Flight::class ? 'selected':'' }}>
                                        Flight
                                    </option>

                                    <option value="App\Models\TourPackage"
                                        {{ old('reviewable_type',$review->reviewable_type)==App\Models\TourPackage::class ? 'selected':'' }}>
                                        Tour Package
                                    </option>

                                </select>

                                @error('reviewable_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- Related Item --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Related Item
                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="reviewable_id"
                                    id="reviewable_id"
                                    class="form-select select2 @error('reviewable_id') is-invalid @enderror">

                                    @if($review->reviewable)

                                        <option
                                            value="{{ $review->reviewable->id }}"
                                            selected>

                                            {{ $review->reviewable->title ?? $review->reviewable->name }}

                                        </option>

                                    @else

                                        <option value="">

                                            Select Item

                                        </option>

                                    @endif

                                </select>

                                @error('reviewable_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- Customer --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Customer
                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="user_id"
                                    id="user_id"
                                    class="form-select select2 @error('user_id') is-invalid @enderror">

                                    <option value="">

                                        Select Customer

                                    </option>

                                    @foreach($users as $user)

                                        <option
                                            value="{{ $user->id }}"
                                            {{ old('user_id',$review->user_id)==$user->id ? 'selected':'' }}>

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

                                <label class="form-label">

                                    Booking
                                    <small class="text-muted">(Optional)</small>

                                </label>

                                <select
                                    name="booking_id"
                                    id="booking_id"
                                    class="form-select select2">

                                    <option value="">

                                        Select Booking

                                    </option>

                                    @foreach($bookings as $booking)

                                        <option
                                            value="{{ $booking->id }}"
                                            {{ old('booking_id',$review->booking_id)==$booking->id ? 'selected':'' }}>

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

                                <label class="form-label">

                                    Rating
                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="rating"
                                    class="form-select select2 @error('rating') is-invalid @enderror">

                                    <option value="">Select Rating</option>

                                    @for($i = 5; $i >= 1; $i--)

                                        <option
                                            value="{{ $i }}"
                                            {{ old('rating',$review->rating) == $i ? 'selected' : '' }}>

                                            {{ str_repeat('⭐',$i) }}
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

                            {{-- Review Title --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Review Title

                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title',$review->title) }}"
                                    placeholder="Amazing Experience">

                                @error('title')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            {{-- Review --}}
                            <div class="col-md-12 mb-3">

                                <label class="form-label">

                                    Review
                                    <span class="text-danger">*</span>

                                </label>

                                <textarea
                                    id="review"
                                    name="review"
                                    rows="8"
                                    class="form-control @error('review') is-invalid @enderror">{{ old('review',$review->review) }}</textarea>

                                @error('review')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            {{-- Pros --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Pros

                                </label>

                                <textarea
                                    name="pros"
                                    rows="5"
                                    class="form-control @error('pros') is-invalid @enderror"
                                    placeholder="Friendly staff, Beautiful view...">{{ old('pros',$review->pros) }}</textarea>

                                @error('pros')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            {{-- Cons --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Cons

                                </label>

                                <textarea
                                    name="cons"
                                    rows="5"
                                    class="form-control @error('cons') is-invalid @enderror"
                                    placeholder="Slow WiFi, Limited Parking...">{{ old('cons',$review->cons) }}</textarea>

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

            {{--------------- RIGHT SIDEBAR ---------------}}
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

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_verified"
                                name="is_verified"
                                value="1"
                                {{ old('is_verified', $review->is_verified) ? 'checked' : '' }}>

                            <label
                                class="form-check-label"
                                for="is_verified">

                                Verified Review

                            </label>

                        </div>

                        {{-- Featured --}}
                        <div class="form-check form-switch mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_featured"
                                name="is_featured"
                                value="1"
                                {{ old('is_featured', $review->is_featured) ? 'checked' : '' }}>

                            <label
                                class="form-check-label"
                                for="is_featured">

                                Featured Review

                            </label>

                        </div>

                        {{-- Approved --}}
                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="status"
                                name="status"
                                value="1"
                                {{ old('status', $review->status) ? 'checked' : '' }}>

                            <label
                                class="form-check-label"
                                for="status">

                                Approved

                            </label>

                        </div>

                    </div>

                </div>

                {{-- Approval Information --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Approval Information

                        </h5>

                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Approved At</label>
                            <input type="datetime-local" name="approved_at" class="form-control"
                                value="{{ old('approved_at', optional($review->approved_at)->format('Y-m-d\TH:i')) }}">

                            <small class="text-muted">
                                Leave empty if review has not been approved.
                            </small>
                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Created At

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $review->created_at->format('d M Y h:i A') }}"
                                readonly>

                        </div>

                        <div>

                            <label class="form-label">

                                Last Updated

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $review->updated_at->format('d M Y h:i A') }}"
                                readonly>

                        </div>

                    </div>

                </div>

                {{-- Submit --}}
                <div class="card">

                    <div class="card-body">

                        <div class="d-grid gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="ti ti-device-floppy me-1"></i>

                                Update Review

                            </button>

                            <a
                                href="{{ route('reviews.index') }}"
                                class="btn btn-outline-secondary">

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
    @include('admin.reviews.edit-script')
@endpush
