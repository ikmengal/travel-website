@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Edit Tour Departure
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('tour_departures.index') }}">
                            Tour Departures
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Edit
                    </li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('tour_departures.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left"></i>
            Back
        </a>
    </div>

    <form action="{{ route('tour_departures.update',$tourDeparture->id) }}" method="POST" id="tourDepartureForm">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- LEFT SIDE --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Departure Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Tour --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Tour <span class="text-danger">*</span></label>
                                <select name="tour_id"
                                    class="form-select select2 @error('tour_id') is-invalid @enderror">

                                    <option value=""> Select Tour </option>

                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}"
                                            {{ old('tour_id',$tourDeparture->tour_id)==$tour->id ? 'selected' : '' }}>
                                            {{ $tour->title }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('tour_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Departure Date --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Departure Date</label>

                                <input type="date" name="departure_date"
                                    value="{{ old('departure_date',$tourDeparture->departure_date->format('Y-m-d')) }}"
                                    class="form-control @error('departure_date') is-invalid @enderror">

                                @error('departure_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Return Date --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Return Date</label>

                                <input type="date" name="return_date"
                                    value="{{ old('return_date',$tourDeparture->return_date->format('Y-m-d')) }}"
                                    class="form-control @error('return_date') is-invalid @enderror">

                                @error('return_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        PKR
                                    </span>

                                    <input type="number" step="0.01" min="0" name="price"
                                        value="{{ old('price',$tourDeparture->price) }}"
                                        class="form-control @error('price') is-invalid @enderror">
                                </div>

                                @error('price')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Seats --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Available Seats</label>
                                <input type="number" min="1" name="available_seats"
                                    value="{{ old('available_seats',$tourDeparture->available_seats) }}"
                                    class="form-control @error('available_seats') is-invalid @enderror">

                                @error('available_seats')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-4">

                {{-- Status --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Settings
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                {{ old('status',$tourDeparture->status) ? 'checked' : '' }}>

                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Summary
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Departure
                            </small>
                            <strong id="departurePreview">
                                {{ $tourDeparture->departure_date->format('d M Y') }}
                            </strong>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Return
                            </small>
                            <strong id="returnPreview">
                                {{ $tourDeparture->return_date->format('d M Y') }}
                            </strong>
                        </div>

                        <hr>

                        <div>
                            <small class="text-muted d-block">
                                Seats
                            </small>
                            <strong id="seatPreview">
                                {{ $tourDeparture->available_seats }}
                            </strong>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Update Departure
                            </button>

                            <a href="{{ route('tour_departures.index') }}" class="btn btn-outline-secondary">
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
    @include('admin.tour-departures.edit-script')
@endpush
