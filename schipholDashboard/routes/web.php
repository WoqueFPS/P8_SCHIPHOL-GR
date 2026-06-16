<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Staff\ReportController;
use App\Http\Controllers\Staff\AuthController as StaffAuthController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\TermsController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// statische pagina
Route::get('/terms', fn() => view('pages.terms'))->name('terms.show');

// publieke vluchtinfo
Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
Route::get('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::get('/flights/{flight}', [FlightController::class, 'show'])->name('flights.show');

// REIZIGERS web guard

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/terms-verify', [TermsController::class, 'showTerms'])->name('terms.verify');
Route::post('/terms/accept', [TermsController::class, 'acceptTerms'])->name('terms.accept');
Route::post('/terms/reject', [TermsController::class, 'rejectTerms'])->name('terms.reject');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bookings/confirmation/{bookingNumber}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::delete('/bookings/{booking}', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{flight}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{flight}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// MEDEWERKERS staff guard /staff/

Route::prefix('staff')->name('staff.')->group(function () {

    Route::middleware('guest:staff')->group(function () {
        Route::get('/login', [StaffAuthController::class, 'loginForm'])->name('login');
        Route::post('/login', [StaffAuthController::class, 'login']);
    });

    Route::post('/logout', [StaffAuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth:staff');

    Route::middleware('auth:staff')->group(function () {

    Route::get('/redirect', function () {
        $user = auth()->guard('staff')->user();

        if ($user->hasRole('directeur')) {
            return redirect()->route('staff.reports.index');
        }
            
        return redirect()->route('staff.flights.manage');
    })->name('redirect');

        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

        // vluchtcoordinatoren + directeur
        Route::middleware('role:coordinator,directeur')->group(function () {
            Route::get('/flights-management', [FlightController::class, 'manage'])->name('flights.manage');
            Route::get('/flights-management/create', [FlightController::class, 'create'])->name('flights.create');
            Route::post('/flights-management', [FlightController::class, 'store'])->name('flights.store');
            Route::get('/flights-management/{flight}/edit', [FlightController::class, 'edit'])->name('flights.edit');
            Route::put('/flights-management/{flight}', [FlightController::class, 'update'])->name('flights.update');
            Route::delete('/flights-management/{flight}', [FlightController::class, 'destroy'])->name('flights.destroy');
        });

        // directeur
        Route::middleware('role:directeur')->group(function () {
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
            Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
            Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
            Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
            Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
            Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');

            Route::post('/director/toggle-noodmodus', [ReportController::class, 'toggleNoodmodus'])->name('director.toggle-noodmodus');
            Route::post('/director/set-priority', [ReportController::class, 'setPriority'])->name('director.set-priority');
            Route::post('/director/broadcast', [ReportController::class, 'broadcastMessage'])->name('director.broadcast');
            Route::post('/director/update-team', [ReportController::class, 'updateTeam'])->name('director.update-team');
            Route::post('/director/reset-teams', [ReportController::class, 'resetTeams'])->name('director.reset-teams');
            Route::get('/director/settings', [ReportController::class, 'getSettings'])->name('director.settings');
        });
    });
});