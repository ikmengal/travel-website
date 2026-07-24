@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{------------- PAGE HEADER -------------}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="ti ti-route-2 text-primary me-2"></i>
                    {{ $tour->title }}
                </h4>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('tours.index') }}">
                                Tours
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            Details
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="d-flex gap-2">
                @can('tours-edit')
                    <a href="{{ route('tours.edit',$tour->id) }}" class="btn btn-warning">
                        <i class="ti ti-edit me-1"></i>
                        Edit Tour
                    </a>
                @endcan

                <a href="{{ route('tours.index') }}"class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back
                </a>
            </div>
        </div>

    {{------------- HERO CARD -------------}}
        <div class="card mb-4 overflow-hidden">
            <div class="position-relative">
                <img
                    src="{{ $tour->featured_image ? asset($tour->featured_image) : asset('admin/assets/img/illustrations/placeholder.jpg') }}"
                    class="w-100" style="height:350px;object-fit:cover;">
                <div class="position-absolute top-0 start-0 w-100 h-100"
                    style="background:linear-gradient(to top,rgba(0,0,0,.75),rgba(0,0,0,.15));">
                </div>

                <div class="position-absolute bottom-0 start-0 p-4 text-white w-100">
                    <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <div>
                            <span class="badge bg-primary mb-2">{{ $tour->tour_code }}</span>
                            @if($tour->tagline)
                                <h6 class="text-white-50 mb-1">{{ $tour->tagline }}</h6>
                            @endif
                            <h2 class="text-white fw-bold mb-2">{{ $tour->title }}</h2>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span>
                                    <i class="ti ti-map-pin me-1"></i>
                                    {{ optional($tour->destination)->name }}
                                </span>

                                @if($tour->category)
                                    <span>
                                        <i class="ti ti-category me-1"></i>
                                        {{ $tour->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="text-end">
                            <h2 class="text-warning fw-bold mb-1">
                                ${{ number_format($tour->discount_price ?: $tour->price,2) }}
                            </h2>

                            @if($tour->discount_price)
                                <small class="text-decoration-line-through text-white-50">
                                    ${{ number_format($tour->price,2) }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{------------- STATUS BADGES -------------}}
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            @if($tour->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                        <small class="text-muted">Tour Status</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            @if($tour->featured)
                                <span class="badge bg-warning">Featured</span>
                            @else
                                <span class="badge bg-label-secondary">Normal</span>
                            @endif
                        </div>
                        <small class="text-muted">Featured</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            @if($tour->popular)
                                <span class="badge bg-info">Popular</span>
                            @else
                                <span class="badge bg-label-secondary">Standard</span>
                            @endif
                        </div>
                        <small class="text-muted">Popularity</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <span class="badge bg-primary">⭐ {{ number_format($tour->rating,1) }}</span>
                        </div>
                        <small class="text-muted">Rating ({{ $tour->reviews_count }} Reviews)</small>
                    </div>
                </div>
            </div>
        </div>

    {{------------- TOUR INFORMATION -------------}}
        <div class="row">
            {{-- Left Side --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-info-circle text-primary me-2"></i>
                            Tour Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <label class="text-muted small">Tour Title</label>
                                <h6 class="fw-semibold">{{ $tour->title }}</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Tour Code</label>
                                <h6>
                                    <span class="badge bg-label-primary">
                                        {{ $tour->tour_code }}
                                    </span>
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Destination</label>
                                <h6>{{ optional($tour->destination)->name }}</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Category</label>
                                <h6>{{ optional($tour->category)->name ?? '-' }}</h6>
                            </div>

                            <div class="col-md-12">
                                <label class="text-muted small">Tagline</label>
                                <p class="mb-0">{{ $tour->tagline ?: '-' }}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="text-muted small">Short Description</label>
                                <p class="mb-0">{{ $tour->short_description ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-currency-dollar text-success me-2"></i>
                            Pricing
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Regular Price</small>
                                    <h4 class="fw-bold text-primary mb-0">
                                        ${{ number_format($tour->price,2) }}
                                    </h4>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Discount Price</small>
                                    <h4 class="fw-bold text-success mb-0">
                                        {{ $tour->discount_price ? '$'.number_format($tour->discount_price,2) : '-' }}
                                    </h4>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Saving</small>
                                    <h4 class="fw-bold text-danger mb-0">
                                        @if($tour->discount_price)
                                            ${{ number_format($tour->price-$tour->discount_price,2) }}
                                        @else
                                            -
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4">
                {{-- Duration --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-clock text-warning me-2"></i>
                            Tour Duration
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Days</span>
                            <strong>{{ $tour->duration_days }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Nights</span>
                            <strong>{{ $tour->duration_nights }}</strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Total Duration</span>
                            <strong>
                                {{ $tour->duration_days }}D /
                                {{ $tour->duration_nights }}N
                            </strong>
                        </div>
                    </div>
                </div>

                {{-- Capacity --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-users text-info me-2"></i>
                            Capacity
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Maximum People</span>
                            <strong>{{ $tour->max_people }}</strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Minimum Age</span>
                            <strong>{{ $tour->min_age ?: '-' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Quick Statistics --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-chart-bar text-primary me-2"></i>
                            Quick Statistics
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Reviews</span>
                            <strong>{{ $tour->reviews_count }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Rating</span>
                            <strong>⭐ {{ number_format($tour->rating,1) }}</strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Sort Order</span>
                            <strong>{{ $tour->sort_order }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{------------- DESCRIPTION -------------}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ti ti-align-left text-primary me-2"></i>
                    Tour Description
                </h5>
            </div>

            <div class="card-body">
                @if($tour->description)
                    {!! $tour->description !!}
                @else
                    <div class="alert alert-warning mb-0">
                        No description available.
                    </div>
                @endif
            </div>
        </div>

    {{------------- SEO INFORMATION -------------}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ti ti-world text-success me-2"></i>
                    SEO Information
                </h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="text-muted small">Meta Title</label>
                        <h6 class="mb-0">{{ $tour->meta_title ?: '-' }}</h6>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small">Meta Description</label>
                        <p class="mb-0">{{ $tour->meta_description ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

    {{------------- GOOGLE SEARCH PREVIEW -------------}}
        <div class="card mb-4">
            <div class="card-header bg-label-success">
                <h5 class="mb-0">
                    <i class="ti ti-brand-google me-2"></i>
                    Google Search Preview
                </h5>
            </div>

            <div class="card-body">
                <h5 class="text-primary mb-1">{{ $tour->meta_title ?: $tour->title }}</h5>
                <div class="text-success small mb-2">{{ url('tours/'.$tour->slug) }}</div>
                <div class="text-muted">
                    {{ $tour->meta_description ?: $tour->short_description }}
                </div>
            </div>
        </div>

    {{------------- SYSTEM INFORMATION -------------}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ti ti-database text-info me-2"></i>
                    System Information
                </h5>
            </div>

            <div class="card-body">
                <div class="row gy-4">
                    <div class="col-md-6">
                        <label class="text-muted small">Tour ID</label>
                        <h6>#{{ $tour->id }}</h6>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Slug</label>
                        <h6>{{ $tour->slug }}</h6>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Created At</label>
                        <h6>{{ $tour->created_at->format('d M, Y h:i A') }}</h6>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Last Updated</label>
                        <h6>{{ $tour->updated_at->format('d M, Y h:i A') }}</h6>
                    </div>
                </div>
            </div>
        </div>

    {{------------- QUICK ACTIONS -------------}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ti ti-settings me-2 text-warning"></i>
                    Quick Actions
                </h5>

            </div>

            <div class="card-body">
                <div class="d-grid gap-2">
                    @can('tours-edit')
                        <a href="{{ route('tours.edit',$tour->id) }}" class="btn btn-warning">
                            <i class="ti ti-edit me-1"></i>
                            Edit Tour
                        </a>
                    @endcan
                    <a href="{{ route('tours.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-list me-1"></i>
                        All Tours
                    </a>
                </div>
            </div>
        </div>

    {{------------- TOUR GALLERY -------------}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ti ti-photo me-2 text-primary"></i>
                    Tour Gallery
                </h5>
                <span class="badge bg-primary">
                    {{ $tour->images->count() }} Images
                </span>
            </div>

            <div class="card-body">
                @if($tour->images->count())
                    <div class="row">
                        @foreach($tour->images as $image)
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                <div class="card shadow-none border">
                                    <img src="{{ asset($image->image) }}" class="card-img-top" style="height:220px;object-fit:cover;">
                                    <div class="card-body py-2 text-center">
                                        <small class="text-muted">
                                            Image #{{ $loop->iteration }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        No gallery images available.
                    </div>
                @endif
            </div>
        </div>

    {{------------- ITINERARY -------------}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ti ti-calendar-event me-2 text-success"></i>
                    Tour Itinerary
                </h5>

                <span class="badge bg-success">
                    {{ $tour->itineraries->count() }} Days
                </span>
            </div>

            <div class="card-body">
                @forelse($tour->itineraries as $item)
                    <div class="border rounded p-4 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Day {{ $item->day }}</h5>
                        </div>
                        <h6>{{ $item->title }}</h6>
                        <div>{!! $item->description !!}</div>
                    </div>
                @empty
                    <div class="alert alert-warning mb-0">
                        No itinerary available.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="row">
            {{------------- INCLUDED -------------}}
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-circle-check me-2 text-success"></i>
                            Tour Includes
                        </h5>
                    </div>

                    <div class="card-body">
                        @if($tour->includes->count())
                            <ul class="list-group list-group-flush">
                                @foreach($tour->includes as $include)
                                    <li class="list-group-item">
                                        <i class="ti ti-check text-success me-2"></i>
                                        {{ $include->title }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-warning mb-0">
                                No included services.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{------------- EXCLUDED -------------}}
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-circle-x me-2 text-danger"></i>
                            Tour Excludes
                        </h5>
                    </div>

                    <div class="card-body">
                        @if($tour->excludes->count())
                            <ul class="list-group list-group-flush">
                                @foreach($tour->excludes as $exclude)
                                    <li class="list-group-item">
                                        <i class="ti ti-x text-danger me-2"></i>
                                        {{ $exclude->title }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-warning mb-0">
                                No excluded services.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    {{------------- DEPARTURE DATES -------------}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="ti ti-plane-departure me-2 text-info"></i>
                Departure Dates
            </h5>

            <span class="badge bg-info">
                {{ $tour->departures->count() }} Departures
            </span>
        </div>

        <div class="card-body">
            @if($tour->departures->count())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th width="80">#</th>
                                <th>Departure Date</th>
                                <th>Available Seats</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tour->departures as $departure)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($departure->departure_date)->format('d M Y') }}</td>
                                    <td>{{ $departure->available_seats ?? '-' }}</td>
                                    <td>
                                        @if($departure->status)
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-danger">Closed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    No departure schedule available.
                </div>
            @endif
        </div>
    </div>
@endsection
