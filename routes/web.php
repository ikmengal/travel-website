<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AuthenticationController,
    PermissionController,
    DashboardController,
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
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/states/{country}', function ($country) {
    return \App\Models\State::where('country_id', $country)->orderBy('name')->get();
});

Route::get('/cities/{state}', function ($state) {
    return \App\Models\City::where('state_id', $state)->orderBy('name')->get();
});
