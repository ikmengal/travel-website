@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold">

                <i class="ti ti-eye me-2 text-primary"></i>

                Review Details

            </h4>

            <p class="text-muted mb-0">

                View complete review information.

            </p>

        </div>

        <div>

            @can('reviews-edit')
                <a href="{{ route('reviews.edit',$review->id) }}"
                    class="btn btn-warning">

                    <i class="ti ti-edit me-1"></i>

                    Edit

                </a>
            @endcan

            <a href="{{ route('reviews.index') }}"
                class="btn btn-outline-secondary">

                <i class="ti ti-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <div class="row">

        {{-- Left --}}
        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Review Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>

                            <th width="220">Review Type</th>

                            <td>

                                {{ class_basename($review->reviewable_type) }}

                            </td>

                        </tr>

                        <tr>

                            <th>Related Item</th>

                            <td>

                                {{ $review->reviewable->title ?? $review->reviewable->name ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>Customer</th>

                            <td>

                                {{ $review->user?->name }}

                                <br>

                                <small class="text-muted">

                                    {{ $review->user?->email }}

                                </small>

                            </td>

                        </tr>

                        <tr>

                            <th>Booking</th>

                            <td>

                                @if($review->booking)

                                    #{{ $review->booking->id }}

                                    @if(isset($review->booking->booking_number))

                                        ({{ $review->booking->booking_number }})

                                    @endif

                                @else

                                    <span class="badge bg-label-secondary">

                                        N/A

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>Rating</th>

                            <td>

                                @for($i=1;$i<=5;$i++)

                                    @if($i <= $review->rating)

                                        <i class="ti ti-star-filled text-warning"></i>

                                    @else

                                        <i class="ti ti-star text-muted"></i>

                                    @endif

                                @endfor

                                <span class="ms-2">

                                    ({{ $review->rating }}/5)

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>Title</th>

                            <td>

                                {{ $review->title ?: '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>Review</th>

                            <td>

                                {!! $review->review !!}

                            </td>

                        </tr>

                        <tr>

                            <th>Pros</th>

                            <td>

                                {!! nl2br(e($review->pros)) ?: '-' !!}

                            </td>

                        </tr>

                        <tr>

                            <th>Cons</th>

                            <td>

                                {!! nl2br(e($review->cons)) ?: '-' !!}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

        {{-- Right --}}
        <div class="col-lg-4">

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Review Status

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>

                            <th>Verified</th>

                            <td class="text-end">

                                @if($review->is_verified)

                                    <span class="badge bg-success">

                                        Verified

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>Featured</th>

                            <td class="text-end">

                                @if($review->is_featured)

                                    <span class="badge bg-warning">

                                        Featured

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>Status</th>

                            <td class="text-end">

                                @if($review->status)

                                    <span class="badge bg-success">

                                        Approved

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Pending

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>Approved At</th>

                            <td class="text-end">

                                {{ $review->approved_at?->format('d M Y h:i A') ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>Created</th>

                            <td class="text-end">

                                {{ $review->created_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                        <tr>

                            <th>Updated</th>

                            <td class="text-end">

                                {{ $review->updated_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            <div class="card">

                <div class="card-body">

                    <div class="d-grid gap-2">

                        @can('reviews-edit')

                            <a href="{{ route('reviews.edit',$review->id) }}"
                                class="btn btn-warning">

                                <i class="ti ti-edit me-1"></i>

                                Edit Review

                            </a>

                        @endcan

                        <a href="{{ route('reviews.index') }}"
                            class="btn btn-outline-secondary">

                            Back to Reviews

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
