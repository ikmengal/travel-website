@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Add Tour Itinerary
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('tour_itineraries.index') }}">
                            Tour Itineraries
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Create
                    </li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('tour_itineraries.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left"></i>
            Back
        </a>
    </div>

    <form action="{{ route('tour_itineraries.store') }}" method="POST" id="tourItineraryForm">
        @csrf
        <div class="row">
            {{---------------- LEFT ----------------}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Itinerary Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Tour --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label"> Tour <span class="text-danger">*</span> </label>
                                <select name="tour_id" class="form-select select2 @error('tour_id') is-invalid @enderror">
                                    <option value="">
                                        Select Tour
                                    </option>
                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}" {{ old('tour_id')==$tour->id ? 'selected' : '' }}>
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

                            {{-- Day --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Day<span class="text-danger">*</span></label>
                                <input type="number" min="1" name="day" value="{{ old('day',1) }}"
                                    class="form-control @error('day') is-invalid @enderror">
                                @error('day')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Title --}}
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Title<span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Example: Arrival & City Tour">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea id="description" name="description" rows="12"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- -------------- RIGHT -------------- --}}
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"> Settings </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="status" value="1" checked>
                            <label class="form-check-label">
                                Active
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save Itinerary
                            </button>
                            <a href="{{ route('tour_itineraries.index') }}" class="btn btn-outline-secondary">
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
    @include('admin.tour_itineraries.create_script')
@endpush
