@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Edit Tour Itinerary
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
                        Edit
                    </li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('tour_itineraries.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left"></i>
            Back
        </a>
    </div>

    <form action="{{ route('tour_itineraries.update',$itinerary->id) }}" method="POST" id="tourItineraryForm">
        @csrf
        @method('PUT')

        <div class="row">
            {{--------------- LEFT ---------------}}
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
                                <label class="form-label"> Tour <span class="text-danger">*</span></label>

                                <select name="tour_id"
                                    class="form-select select2 @error('tour_id') is-invalid @enderror">

                                    <option value="">
                                        Select Tour
                                    </option>
                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}"
                                            {{ old('tour_id',$itinerary->tour_id)==$tour->id ? 'selected' : '' }}>
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
                                <label class="form-label">Day</label>

                                <input type="number" name="day" min="1" value="{{ old('day',$itinerary->day) }}"
                                    class="form-control @error('day') is-invalid @enderror">

                                @error('day')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Title --}}
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Title</label>

                                <input type="text" name="title" value="{{ old('title',$itinerary->title) }}"
                                    class="form-control @error('title') is-invalid @enderror">

                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <label class="form-label"> Description </label>
                                <textarea id="description" name="description" rows="12"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description',$itinerary->description) }}</textarea>

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

            {{-- ------------- RIGHT ------------- --}}
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"> Settings </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="status" value="1"
                                {{ old('status',$itinerary->status) ? 'checked' : '' }}>

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
                                Update Itinerary
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
    @include('admin.tour_itineraries.edit_script')
@endpush
