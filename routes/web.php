<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
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
    TourCountroller,
    RoleController,
    UserController
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

    // Setting Custom Routes
    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::delete('{setting}/toggle-status', 'toggleStatus')->name('bulk-delete');
    });

    Route::resource('tour_itineraries', TourItineraryController::class);
    Route::resource('tour_departures', TourDepartureController::class);
    Route::resource('tour_categories', TourCategoryController::class);
    Route::resource('tour_includes', TourIncludeController::class);
    Route::resource('tour_excludes', TourExcludeController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('tour_images', TourImageController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('tours', TourCountroller::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/states/{country}', function ($country) {
    return \App\Models\State::where('country_id', $country)->orderBy('name')->get();
});

Route::get('/cities/{state}', function ($state) {
    return \App\Models\City::where('state_id', $state)->orderBy('name')->get();
});
