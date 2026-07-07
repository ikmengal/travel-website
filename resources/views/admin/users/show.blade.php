@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    {{-- Breadcrumb --}}
    <div class="row mb-3">
        <div class="col-12">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Users /</span>
                {{ $user->name }}
            </h4>
        </div>
    </div>

    {{-- Cover Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="user-profile-header-banner">
                    <img src="{{ asset('admin/assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top" />
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img
                            src="{{ $user->profile_picture }}"
                            alt="user image"
                            class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img"
                        />
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ $user->name ?? '' }}</h4>
                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item"><i class="ti ti-email"></i> {{ $user->email ?? '' }}</li>
                                    <li class="list-inline-item"><i class="ti ti-map-pin"></i> {{ $user->country->name ?? '-' }}</li>
                                    <li class="list-inline-item"><i class="ti ti-calendar"></i> Joined {{ $user->created_at ?? '' }}</li>
                                </ul>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary">
                                <i class="ti ti-user-check me-1"></i>Connected
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#profile">
                            <i class="ti ti-user me-1"></i>
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#bookings">
                            <i class="ti ti-ticket me-1"></i>
                            Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#wishlist">
                            <i class="ti ti-heart me-1"></i>
                            Wishlist
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#reviews">
                            <i class="ti ti-star me-1"></i>
                            Reviews
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#security">
                            <i class="ti ti-lock me-1"></i>
                            Security
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    {{------------ PROFILE TAB ------------}}
                    <div class="tab-pane fade show active" id="profile">
                        <div class="row">
                            {{-- Left Side --}}
                            <div class="col-xl-4 col-lg-5 col-md-5">
                                {{-- About Card --}}
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <i class="ti ti-user me-2"></i>
                                            About User
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        {{-- Full Name --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Full Name
                                            </small>
                                            <strong>{{ $user->name }}</strong>
                                        </div>

                                        {{-- Username --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Username
                                            </small>
                                            {{ $user->username ?? '-' }}
                                        </div>

                                        {{-- Email --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Email
                                            </small>
                                            {{ $user->email }}
                                        </div>

                                        {{-- Phone --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Phone
                                            </small>
                                            {{ $user->phone ?? '-' }}
                                        </div>

                                        {{-- Gender --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Gender
                                            </small>
                                            {{ $user->gender ?? '-' }}
                                        </div>

                                        {{-- Date of Birth --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Date of Birth
                                            </small>
                                            {{ $user->date_of_birth ?? '-' }}
                                        </div>

                                        {{-- Role --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Role
                                            </small>
                                            @forelse($user->roles as $role)
                                                <span class="badge bg-label-primary me-1">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                -
                                            @endforelse
                                        </div>

                                        {{-- Status --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Status
                                            </small>
                                            @if($user->status=="Active")
                                                <span class="badge bg-success">
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    In Active
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Country --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Country
                                            </small>
                                            {{ $user->country->name ?? '-' }}
                                        </div>

                                        {{-- State --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                State
                                            </small>
                                            {{ $user->state->name ?? '-' }}
                                        </div>

                                        {{-- City --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                City
                                            </small>
                                            {{ $user->city->name ?? '-' }}
                                        </div>

                                        {{-- Address --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Address
                                            </small>
                                            {{ $user->address ?? '-' }}
                                        </div>

                                        {{-- Bio --}}
                                        <div>
                                            <small class="text-muted d-block">
                                                About
                                            </small>
                                            {{ $user->bio ?? 'No bio available.' }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Contact Card --}}
                                <div class="card">
                                    <div class="card-header">
                                        <h5>
                                            <i class="ti ti-address-book me-2"></i>
                                            Contact Information
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <div class="badge bg-label-primary me-2 rounded">
                                                <i class="ti ti-mail mt-1"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">
                                                    Email
                                                </small>
                                                <div>
                                                    {{ $user->email ?? '' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex mb-3">
                                            <div class="badge bg-label-success me-2 rounded">
                                                <i class="ti ti-phone ti-sm mt-1"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">
                                                    Phone
                                                </small>
                                                <div>
                                                    {{ $user->phone ?? '-' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="badge bg-label-warning rounded me-2">
                                                <i class="ti ti-map-pin it-lg mt-1"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">
                                                    Location
                                                </small>
                                                <div>
                                                    {{ $user->city->name ?? '' }}
                                                    {{ $user->state->name ?? '' }}
                                                    {{ $user->country->name ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Side --}}
                            <div class="col-xl-8 col-lg-7 col-md-7">
                                {{-- Statistics --}}
                                <div class="row">
                                    <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted">Bookings</small>
                                                        <h3 class="mb-0">
                                                            {{ $user->bookings_count ?? 0 }}
                                                        </h3>
                                                    </div>
                                                    <div class="badge bg-label-primary p-2 rounded">
                                                        <i class="ti ti-ticket ti-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted">Tours</small>
                                                        <h3 class="mb-0">
                                                            {{ $user->tours_count ?? 0 }}
                                                        </h3>
                                                    </div>
                                                    <div class="badge bg-label-success p-2 rounded">
                                                        <i class="ti ti-map-2 ti-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted">Hotels</small>
                                                        <h3 class="mb-0">
                                                            {{ $user->hotels_count ?? 0 }}
                                                        </h3>
                                                    </div>
                                                    <div class="badge bg-label-info p-2 rounded">
                                                        <i class="ti ti-building-skyscraper ti-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted">Flights</small>
                                                        <h3 class="mb-0">
                                                            {{ $user->flights_count ?? 0 }}
                                                        </h3>
                                                    </div>
                                                    <div class="badge bg-label-danger p-2 rounded">
                                                        <i class="ti ti-plane ti-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-4 col-md-6 col-sm-6 mb-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted"> Cars </small>
                                                        <h3>
                                                            {{ $user->cars_count ?? 0 }}
                                                        </h3>
                                                    </div>
                                                    <div class="badge bg-label-warning p-2 rounded">
                                                        <i class="ti ti-car ti-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 mb-4 col-md-6 col-sm-6 mb-4">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted"> Wishlist </small>
                                                        <h3>
                                                            {{ $user->wishlists_count ?? 0 }}
                                                        </h3>
                                                    </div>
                                                    <div class="badge bg-label-primary p-2 rounded">
                                                        <i class="ti ti-heart ti-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 mb-4 col-md-6 col-sm-6 mb-4">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted">
                                                            Reviews
                                                        </small>
                                                        <h3>
                                                            {{ $user->reviews_count ?? 0 }}
                                                        </h3>
                                                    </div>

                                                    <div class="badge bg-label-success p-2 rounded">
                                                        <i class="ti ti-star ti-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="mb-0">
                                            Recent Activity
                                        </h5>
                                        <span class="badge bg-label-primary">
                                            Timeline
                                        </span>
                                    </div>

                                    <div class="card-body">
                                        <ul class="timeline mb-0">
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-success"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header">
                                                        <h6 class="mb-0">
                                                            User Account Created
                                                        </h6>
                                                        <small>
                                                            {{ $user->created_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                    <p class="mb-0">
                                                        Account was successfully created.
                                                    </p>
                                                </div>
                                            </li>

                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-primary"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header">
                                                        <h6>
                                                            Role Assigned
                                                        </h6>
                                                    </div>
                                                    <p>
                                                        @foreach($user->roles as $role)
                                                            <span class="badge bg-label-primary">
                                                                {{ $role->name }}
                                                            </span>
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </li>

                                            <li class="timeline-item timeline-item-transparent border-0">
                                                <span class="timeline-point timeline-point-info"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header">
                                                        <h6>
                                                            Last Updated
                                                        </h6>
                                                        <small>
                                                            {{ $user->updated_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                    <p class="mb-0">
                                                        User information was recently modified.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- End Profile Tab --}}

                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="ti ti-lock me-2"></i>
                                    Assigned Role & Permissions
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach($user->roles as $role)
                                    <div class="mb-4">
                                        <h6>
                                            <span class="badge bg-primary">
                                                {{ $role->name }}
                                            </span>
                                        </h6>
                                        <div class="mt-3">
                                            @forelse($role->permissions as $permission)
                                                <span class="badge bg-label-primary me-1 mb-2">
                                                    {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                                                </span>
                                            @empty
                                                <span class="text-muted">
                                                    No permissions assigned.
                                                </span>
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{------------ BOOKINGS TAB ------------}}
                    <div class="tab-pane fade" id="bookings">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="ti ti-ticket me-2"></i>
                                    Recent Bookings
                                </h5>
                                <a href="#" class="btn btn-sm btn-primary">
                                    View All
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Booking ID</th>
                                            <th>Service</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Future Dynamic Data --}}

                                        @forelse($user->bookings as $booking)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $booking->booking_no }}</td>
                                            <td>{{ $booking->service->title }}</td>
                                            <td>${{ number_format($booking->total_price,2) }}</td>
                                            <td>
                                                <span class="badge bg-label-success">
                                                    {{ $booking->status }}
                                                </span>
                                            </td>
                                            <td>{{ $booking->created_at->format('d M Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <img src="{{ asset('admin/assets/img/illustrations/page-misc-under-maintenance.png') }}"
                                                    width="180">
                                                <h6 class="mt-3 mb-1">
                                                    No Bookings Found
                                                </h6>
                                                <small class="text-muted">
                                                    User has not made any booking yet.
                                                </small>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{------------ WISHLIST TAB ------------}}
                    <div class="tab-pane fade" id="wishlist">
                        <div class="card">
                            <div class="card-header">
                                <h5>
                                    <i class="ti ti-heart me-2"></i>
                                    Wishlist
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    {{-- Future Loop --}}
                                    @foreach($user->wishlists as $wishlist)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="border rounded p-4 text-center">
                                                <div class="avatar avatar-xl bg-label-danger mx-auto mb-3">
                                                    <i class="ti ti-heart-filled ti-lg"></i>
                                                </div>
                                                <h6>
                                                    No Wishlist Yet
                                                </h6>
                                                <small class="text-muted">
                                                    User hasn't added any destination,
                                                    hotel or tour.
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{------------ REVIEWS TAB ------------}}
                    <div class="tab-pane fade" id="reviews">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>
                                    <i class="ti ti-star me-2"></i>
                                    User Reviews
                                </h5>
                                <span class="badge bg-label-warning">
                                    {{ $user->reviews_count ?? 0 }} Reviews
                                </span>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Service</th>
                                            <th>Rating</th>
                                            <th>Comment</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Future Reviews --}}
                                        @foreach($user->reviews as $review)
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <img src="{{ asset('admin/assets/img/illustrations/page-misc-under-maintenance.png') }}"
                                                        width="180">
                                                    <h6 class="mt-3">
                                                        No Reviews Available
                                                    </h6>
                                                    <small class="text-muted">
                                                        This user hasn't submitted any review.
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{------------ SECURITY TAB ------------}}
                    <div class="tab-pane fade" id="security">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <i class="ti ti-shield-lock me-2"></i>
                                            Account Security
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Email Verification
                                            </small>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">
                                                    Verified
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Not Verified
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Account Status
                                            </small>
                                            @if($user->status=="Active")
                                                <span class="badge bg-success">
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                Registered
                                            </small>
                                            {{ $user->created_at->format('d M Y h:i A') }}
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">
                                                Last Updated
                                            </small>
                                            {{ $user->updated_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <i class="ti ti-devices me-2"></i>
                                            Login Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-primary">
                                            Login history module will be
                                            available soon.
                                        </div>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="150">
                                                    Browser
                                                </th>
                                                <td>
                                                    --
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Device
                                                </th>
                                                <td>
                                                    --
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    IP Address
                                                </th>
                                                <td>
                                                    --
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Last Login
                                                </th>
                                                <td>
                                                    --
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
@endpush
