@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Edit Tour Exnclude
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('tour_excludes.index') }}">
                            Tour Excludes
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Edit
                    </li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('tour_excludes.index') }}" class="btn btn-label-secondary">
            <i class="ti ti-arrow-left"></i>
            Back
        </a>
    </div>

    <form
        action="{{ route('tour_excludes.update',$tourExclude->id) }}"
        method="POST"
        id="tourExncludeForm">

        @csrf
        @method('PUT')

        <div class="row">

            {{-- ================= LEFT ================= --}}

            <div class="col-lg-8">

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Exnclude Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Tour --}}
                            <div class="col-md-12 mb-3">

                                <label class="form-label">

                                    Tour

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    name="tour_id"
                                    class="form-select select2 @error('tour_id') is-invalid @enderror">

                                    <option value="">

                                        Select Tour

                                    </option>

                                    @foreach($tours as $tour)

                                        <option
                                            value="{{ $tour->id }}"
                                            {{ old('tour_id',$tourExclude->tour_id)==$tour->id ? 'selected' : '' }}>

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

                            {{-- Title --}}
                            <div class="col-md-12 mb-3">

                                <label class="form-label">

                                    Exnclude Title

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    value="{{ old('title',$tourExclude->title) }}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Hotel Accommodation">

                                @error('title')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            {{-- Icon --}}
                            <div class="col-md-8 mb-3">

                                <label class="form-label">

                                    Tabler Icon

                                </label>

                                <input
                                    type="text"
                                    id="icon"
                                    name="icon"
                                    value="{{ old('icon',$tourExclude->icon) }}"
                                    class="form-control @error('icon') is-invalid @enderror"
                                    placeholder="ti ti-home">

                                @error('icon')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                                <small class="text-muted">

                                    Example: ti ti-plane, ti ti-home, ti ti-ticket

                                </small>

                            </div>

                            {{-- Preview --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Icon Preview

                                </label>

                                <div
                                    id="iconPreview"
                                    class="border rounded d-flex align-items-center justify-content-center"
                                    style="height:58px;font-size:28px;">

                                    <i class="{{ $tourExclude->icon }}"></i>

                                </div>

                            </div>

                            {{-- Sort --}}
                            <div class="col-md-6">

                                <label class="form-label">

                                    Sort Order

                                </label>

                                <input
                                    type="number"
                                    name="sort_order"
                                    value="{{ old('sort_order',$tourExclude->sort_order) }}"
                                    class="form-control">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ================= RIGHT ================= --}}

            <div class="col-lg-4">

                {{-- Settings --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Settings

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="form-check form-switch">

                            <input
                                type="checkbox"
                                name="status"
                                value="1"
                                class="form-check-input"
                                {{ old('status',$tourExclude->status) ? 'checked' : '' }}>

                            <label class="form-check-label">

                                Active

                            </label>

                        </div>

                    </div>

                </div>

                {{-- Popular Icons --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            Popular Icons

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="d-flex flex-wrap gap-2">

                            <span class="badge bg-label-primary icon-item" data-icon="ti ti-home">
                                <i class="ti ti-home"></i>
                            </span>

                            <span class="badge bg-label-primary icon-item" data-icon="ti ti-plane">
                                <i class="ti ti-plane"></i>
                            </span>

                            <span class="badge bg-label-primary icon-item" data-icon="ti ti-map-pin">
                                <i class="ti ti-map-pin"></i>
                            </span>

                            <span class="badge bg-label-primary icon-item" data-icon="ti ti-ticket">
                                <i class="ti ti-ticket"></i>
                            </span>

                            <span class="badge bg-label-primary icon-item" data-icon="ti ti-car">
                                <i class="ti ti-car"></i>
                            </span>

                            <span class="badge bg-label-primary icon-item" data-icon="ti ti-bus">
                                <i class="ti ti-bus"></i>
                            </span>

                            <span class="badge bg-label-primary icon-item" data-icon="ti ti-wifi">
                                <i class="ti ti-wifi"></i>
                            </span>

                            <span class="badge bg-label-primary icon-item" data-icon="ti ti-camera">
                                <i class="ti ti-camera"></i>
                            </span>

                        </div>

                    </div>

                </div>

                {{-- Buttons --}}
                <div class="card">

                    <div class="card-body">

                        <div class="d-grid gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="ti ti-device-floppy me-1"></i>

                                Update Exnclude

                            </button>

                            <a
                                href="{{ route('tour_excludes.index') }}"
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
    @include('admin.tour_excludes.edit_script')
@endpush
