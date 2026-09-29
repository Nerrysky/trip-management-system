<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (all authenticated)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin + Staff only — Trip CRUD
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('trips', TripController::class);
    Route::get('bookings', [BookingController::class, 'adminIndex'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'adminShow'])->name('bookings.show');
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
});

// Customer — view trips + book
Route::middleware(['auth'])->group(function () {
    Route::get('trips', [TripController::class, 'publicIndex'])->name('trips.index');
    Route::get('trips/{trip}', [TripController::class, 'publicShow'])->name('trips.show');
    Route::get('bookings/create/{trip}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings/{trip}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::get('bookings/{booking}/view', [BookingController::class, 'show'])->name('bookings.show');
});

require __DIR__.'/auth.php';