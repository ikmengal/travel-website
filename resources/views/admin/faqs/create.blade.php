@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{------------- PAGE HEADER -------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-2">
                <i class="ti ti-help ti-md text-primary"></i>
                Create FAQ
            </h4>
            <p class="text-muted mb-0">
                Create a new FAQ for Tour, Hotel, Destination, Car, Flight or Package.
            </p>
        </div>

        <a href="{{ route('faqs.index') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-1"></i>
            Back
        </a>
    </div>

    {{------------- BREADCRUMB -------------}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('faqs.index') }}">
                    FAQ Management
                </a>
            </li>

            <li class="breadcrumb-item active">
                Create FAQ
            </li>
        </ol>
    </nav>

    {{------------- FORM -------------}}
    <form action="{{ route('faqs.store') }}" method="POST" id="faqForm">
        @csrf
        <div class="row">
            {{------------- LEFT SIDE -------------}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            FAQ Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- FAQ TYPE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">FAQ Type <span class="text-danger">*</span></label>

                                <select name="faqable_type" id="faqable_type" class="form-select select2 @error('faqable_type') is-invalid @enderror">
                                    <option value="">Select Type</option>
                                    <option value="App\Models\Tour">Tour</option>
                                    <option value="App\Models\Hotel">Hotel</option>
                                    <option value="App\Models\Destination">Destination</option>
                                    <option value="App\Models\Car">Car</option>
                                    <option value="App\Models\Flight">Flight</option>
                                    {{-- <option value="App\Models\TourPackage">Tour Package</option> --}}
                                </select>

                                @error('faqable_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- RELATED ITEM --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Related Item <span class="text-danger">*</span></label>

                                <select name="faqable_id" id="faqable_id" class="form-select select2 @error('faqable_id') is-invalid @enderror">
                                    <option value="">Select Type First</option>
                                </select>

                                @error('faqable_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Question --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Question <span class="text-danger">*</span></label>
                                <input type="text" name="question" id="question" value="{{ old('question') }}"
                                    class="form-control @error('question') is-invalid @enderror"
                                    placeholder="Enter FAQ Question">

                                @error('question')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror
                            </div>

                            {{-- Answer --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Answer <span class="text-danger">*</span></label>

                                <textarea id="answer" name="answer" rows="8"
                                    class="form-control @error('answer') is-invalid @enderror"
                                    placeholder="Write FAQ Answer...">{{ old('answer') }}</textarea>

                                @error('answer')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>

                                <input type="number" name="sort_order" min="0" value="{{ old('sort_order',0) }}"
                                    class="form-control @error('sort_order') is-invalid @enderror">

                                @error('sort_order')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{------------- RIGHT SIDEBAR -------------}}
            <div class="col-lg-4">
                {{-- Settings --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Settings
                        </h5>
                    </div>

                    <div class="card-body">
                        {{-- Featured --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured"> Featured FAQ</label>
                        </div>

                        {{-- Status --}}
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status',1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status"> Active </label>
                        </div>
                    </div>
                </div>

                {{-- Preview --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Live Preview
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">
                                FAQ Type
                            </small>
                            <h6 class="mb-0 mt-1" id="previewType">
                                --
                            </h6>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted">
                                Related Item
                            </small>

                            <h6 class="mb-0 mt-1" id="previewItem">
                                --
                            </h6>
                        </div>

                        <hr>

                        <div>
                            <small class="text-muted">
                                Question
                            </small>

                            <p class="mb-0 mt-1 fw-semibold" id="previewQuestion">
                                Your FAQ question will appear here...
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Save FAQ
                            </button>

                            <button type="reset" class="btn btn-outline-warning">
                                <i class="ti ti-refresh me-1"></i>
                                Reset
                            </button>

                            <a href="{{ route('faqs.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-1"></i>
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
    @include('admin.faqs.create-script')
@endpush
