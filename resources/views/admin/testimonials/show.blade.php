@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-message-2 text-warning me-2"></i>
                {{ $title }}
            </h4>
            <p class="text-muted mb-0">
                View testimonial details.
            </p>
        </div>

        <div class="d-flex gap-2">
            @can('testimonials-edit')
                <a href="{{ route('testimonials.edit',$testimonial->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan
            <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Left Side --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($testimonial->image)
                        <img src="{{ asset('images/testimonials/'.$testimonial->image) }}"
                            class="rounded-circle mb-3" width="140" height="140"
                            style="object-fit:cover">
                    @else
                        <div class="avatar avatar-xl mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-label-primary fs-1">
                                {{ strtoupper(substr($testimonial->name,0,1)) }}
                            </span>
                        </div>
                    @endif
                    <h4 class="mb-1">
                        {{ $testimonial->name }}
                    </h4>
                    <p class="text-primary mb-1">
                        {{ $testimonial->designation }}
                    </p>
                    <p class="text-muted">
                        {{ $testimonial->company }}
                    </p>

                    {{-- Rating --}}
                    <div class="mb-3">
                        @for($i=1;$i<=5;$i++)
                            @if($i <= $testimonial->rating)
                                <i class="ti ti-star text-warning fs-4"></i>
                            @else
                                <i class="ti ti-star text-muted fs-4"></i>
                            @endif
                        @endfor
                    </div>

                    {{-- Featured --}}
                    @if($testimonial->featured)
                        <span class="badge bg-label-warning">
                            <i class="ti ti-star-filled me-1"></i>
                            Featured
                        </span>
                    @else
                        <span class="badge bg-label-secondary">
                            Normal
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Side --}}
        <div class="col-lg-8">
            {{-- Review --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-message-circle me-2"></i>
                        Customer Review
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0" style="white-space:pre-line;line-height:1.8">{!! $testimonial->review !!}</p>
                </div>
            </div>

            {{-- Information --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-info-circle me-2"></i>
                        Additional Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="fw-semibold text-muted">Status</label>
                            <div class="mt-1">
                                @if($testimonial->status)
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

                        <div class="col-md-6 mb-4">
                            <label class="fw-semibold text-muted">Sort Order</label>
                            <div class="mt-1">
                                {{ $testimonial->sort_order }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="fw-semibold text-muted">Meta Title</label>
                            <div class="mt-1">
                                {{ $testimonial->meta_title ?: '-' }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="fw-semibold text-muted">Meta Description</label>
                            <div class="mt-1">
                                {{ $testimonial->meta_description ?: '-' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold text-muted">Created At</label>
                            <div class="mt-1">
                                {{ $testimonial->created_at->format('d M Y h:i A') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold text-muted">Updated At</label>
                            <div class="mt-1">
                                {{ $testimonial->updated_at->format('d M Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
