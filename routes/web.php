<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPGController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PGController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pgs', [PGController::class, 'index'])->name('pgs.index');
Route::get('/pgs/{pg}', [PGController::class, 'show'])->name('pgs.show');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pgs/{pg}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/pgs/{pg}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // PGs Management
    Route::get('/pgs', [AdminPGController::class, 'index'])->name('pgs.index');
    Route::get('/pgs/create', [AdminPGController::class, 'create'])->name('pgs.create');
    Route::post('/pgs', [AdminPGController::class, 'store'])->name('pgs.store');
    Route::get('/pgs/{pg}', [AdminPGController::class, 'show'])->name('pgs.show');
    Route::get('/pgs/{pg}/edit', [AdminPGController::class, 'edit'])->name('pgs.edit');
    Route::put('/pgs/{pg}', [AdminPGController::class, 'update'])->name('pgs.update');
    Route::delete('/pgs/{pg}', [AdminPGController::class, 'destroy'])->name('pgs.destroy');
    Route::delete('/pgs/{pg}/images/{image}', [AdminPGController::class, 'deleteImage'])->name('pgs.images.destroy');
    Route::post('/pgs/{pg}/images/{image}/set-primary', [AdminPGController::class, 'setPrimaryImage'])->name('pgs.images.set-primary');

    // Bookings Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');

    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
});

// Laravel Breeze auth routes
require __DIR__.'/auth.php';
