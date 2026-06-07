<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Staff\AuthController as StaffAuthController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

//publieke vluchtinfo
Route::get('/flights',          [FlightController::class, 'index'])->name('flights.index');
Route::get('/flights/search',   [FlightController::class, 'search'])->name('flights.search');
Route::get('/flights/{flight}', [FlightController::class, 'show'])->name('flights.show');

//REIZIGERS web guard

// gasten only (niet ingelogde reizigers)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

//uitloggen
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Ingelogde reizigers
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/bookings',           [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}',  [BookingController::class, 'show'])->name('bookings.show');
    Route::delete('/bookings/{booking}',[BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::post('/wishlist/{flight}',   [FlightController::class, 'addToWishlist'])->name('wishlist.add');
    Route::delete('/wishlist/{flight}', [FlightController::class, 'removeFromWishlist'])->name('wishlist.remove');
});

// MEDEWERKERS staff guard   /staff/

Route::prefix('staff')->name('staff.')->group(function () {

    // gasten only (niet ingelogde medewerkers)
    Route::middleware('guest:staff')->group(function () {
        Route::get('/login',  [StaffAuthController::class, 'loginForm'])->name('login');
        Route::post('/login', [StaffAuthController::class, 'login']);
    });

    // uitloggen
    Route::post('/logout', [StaffAuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth.staff');

    // alle ingelogde medewerkers
    Route::middleware('auth.staff')->group(function () {

        Route::get('/dashboard', fn() => view('staff.dashboard'))->name('dashboard');

        // vluchtcoordinatoren + directeur
        Route::middleware('role:coordinator,directeur')->group(function () {
            Route::get('/flights-management', [FlightController::class, 'manage'])->name('flights.manage');
        });

        // directeur
        Route::middleware('role:directeur')->group(function () {
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        });
    });
});