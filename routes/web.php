<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AuthenticationController,
    TourCategoryController,
    DestinationController,
    PermissionController,
    DashboardController,
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

    Route::controller(TourCountroller::class)->prefix('tours')->name('tours.')->group(function () {
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::post('change-status', 'changeStatus')->name('change-status');
        Route::post('change-featured', 'changeFeatured')->name('change-featured');
        Route::post('change-popular', 'changePopular')->name('change-popular');
    });

    // Destination Custom Routes
    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::delete('{setting}/toggle-status', 'toggleStatus')->name('bulk-delete');
    });

    Route::resource('tour_categories', TourCategoryController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('permissions', PermissionController::class);
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
