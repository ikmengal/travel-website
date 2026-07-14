<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    BookingTravelerController,
    AuthenticationController,
    TourItineraryController,
    TourDepartureController,
    TourCategoryController,
    DestinationController,
    TourIncludeController,
    TourExcludeController,
    PermissionController,
    DashboardController,
    TourImageController,
    SettingController,
    BookingController,
    ReviewController,
    TourCountroller,
    RoleController,
    UserController,
    FaqsController
};

Route::get('/', function () {
    return view('home.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'store']);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::view('/dashboard', 'admin.dashboard.index')->name('dashboard');
    Route::get('logout', [AuthenticationController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth'])->group(function(){
    // Setting Custom Routes
    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::delete('{setting}/toggle-status', 'toggleStatus')->name('bulk-delete');
    });

    // Destination Custom Routes
    Route::controller(DestinationController::class)->prefix('destinations')->name('destinations.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::delete('gallery-image/{image}', 'deleteGalleryImage')->name('gallery-image.delete');
        Route::post('states', 'getStates')->name('states');
        Route::post('cities', 'getCities')->name('cities');
    });

    // Tour Custom Routes
    Route::controller(TourCountroller::class)->prefix('tours')->name('tours.')->group(function () {
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-popular', 'changePopular')->name('change-popular');
    });

    // Tour Image Custom Routes
    Route::controller(TourImageController::class)->prefix('tour_images')->name('tour_images.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Tour Itinerary Custom Routes
    Route::controller(TourItineraryController::class)->prefix('tour_itineraries')->name('tour_itineraries.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Tour Includes Custom Routes
    Route::controller(TourIncludeController::class)->prefix('tour_includes')->name('tour_includes.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Tour Excludes Custom Routes
    Route::controller(TourExcludeController::class)->prefix('tour_excludes')->name('tour_excludes.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Tour Departure Custom Routes
    Route::controller(TourDepartureController::class)->prefix('tour_departures')->name('tour_departures.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Faqs Custom Routes
    Route::controller(FaqsController::class)->prefix('faqs')->name('faqs.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('get-models', 'getModels')->name('get-models');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Reviews Custom Routes
    Route::controller(ReviewController::class)->prefix('reviews')->name('reviews.')->group(function () {
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-verified', 'changeVerified')->name('change-verified');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::get('get-models', 'getModels')->name('get-models');
    });

    // Bookings Custom Routes
    Route::controller(BookingController::class)->prefix('bookings')->name('bookings.')->group(function () {
        Route::post('change-payment-status', 'changePaymentStatus')->name('change-payment-status');
        Route::post('get-departures', 'getDepartures')->name('get-departures');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('get-customers', 'getCustomers')->name('get-customers');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::post('get-tours', 'getTours')->name('get-tours');
    });

    // Booking Travelers Custom Routes
    Route::controller(BookingTravelerController::class)->prefix('booking_travelers')->name('booking_travelers.')->group(function () {
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::get('get-bookings', 'getBookings')->name('get-bookings');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    Route::resource('booking_travelers', BookingTravelerController::class);
    Route::resource('tour_itineraries', TourItineraryController::class);
    Route::resource('tour_departures', TourDepartureController::class);
    Route::resource('tour_categories', TourCategoryController::class);
    Route::resource('tour_includes', TourIncludeController::class);
    Route::resource('tour_excludes', TourExcludeController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('tour_images', TourImageController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('tours', TourCountroller::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('faqs', FaqsController::class);
});

Route::get('/states/{country}', function ($country) {
    return \App\Models\State::where('country_id', $country)->orderBy('name')->get();
});

Route::get('/cities/{state}', function ($state) {
    return \App\Models\City::where('state_id', $state)->orderBy('name')->get();
});
