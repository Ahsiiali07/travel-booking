<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FlightController as AdminFlightController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\RefundController as AdminRefundController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\FlightScheduleController;
use App\Http\Controllers\User\HotelScheduleController;
use App\Http\Controllers\User\PackageBookingController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RefundController as UserRefundController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIC ROUTES
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Flights Browsing
Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
Route::get('/flights/{flight}', [FlightController::class, 'show'])->name('flights.show');

// Hotels Browsing
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');

// Packages Browsing
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
// User Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Admin Auth
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin']);
    Route::get('/register', [AuthController::class, 'showAdminRegisterForm'])->name('admin.register');
    Route::post('/register', [AuthController::class, 'adminRegister']);

    // Admin Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showAdminLinkRequestForm'])->name('admin.password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendAdminResetLinkEmail'])->name('admin.password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showAdminResetForm'])->name('admin.password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('admin.password.update');
});

// ==========================================
// USER PROTECTED ROUTES
// ==========================================
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Flight Schedules (Create-Read-Delete)
    Route::get('/flight-schedules', [FlightScheduleController::class, 'index'])->name('flight-schedules.index');
    Route::get('/flights/{flight}/schedule', [FlightScheduleController::class, 'create'])->name('flight-schedules.create');
    Route::post('/flights/{flight}/schedule', [FlightScheduleController::class, 'store'])->name('flight-schedules.store');
    Route::get('/flight-schedules/{reservation}', [FlightScheduleController::class, 'show'])->name('flight-schedules.show');
    Route::delete('/flight-schedules/{reservation}', [FlightScheduleController::class, 'destroy'])->name('flight-schedules.destroy');

    // Hotel Schedules (Create-Read-Delete)
    Route::get('/hotel-schedules', [HotelScheduleController::class, 'index'])->name('hotel-schedules.index');
    Route::get('/hotels/{hotel}/schedule', [HotelScheduleController::class, 'create'])->name('hotel-schedules.create');
    Route::post('/hotels/{hotel}/schedule', [HotelScheduleController::class, 'store'])->name('hotel-schedules.store');
    Route::get('/hotel-schedules/{reservation}', [HotelScheduleController::class, 'show'])->name('hotel-schedules.show');
    Route::delete('/hotel-schedules/{reservation}', [HotelScheduleController::class, 'destroy'])->name('hotel-schedules.destroy');

    // Package Bookings (Book-Read-Delete)
    Route::get('/package-bookings', [PackageBookingController::class, 'index'])->name('package-bookings.index');
    Route::get('/packages/{package}/book', [PackageBookingController::class, 'create'])->name('package-bookings.create');
    Route::post('/packages/{package}/book', [PackageBookingController::class, 'store'])->name('package-bookings.store');
    Route::get('/package-bookings/{reservation}', [PackageBookingController::class, 'show'])->name('package-bookings.show');
    Route::delete('/package-bookings/{reservation}', [PackageBookingController::class, 'destroy'])->name('package-bookings.destroy');

    // Checkout & Payment
    Route::get('/checkout/{reservation}', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout/{reservation}/pay', [CheckoutController::class, 'process'])->name('checkout.pay');
    Route::get('/invoice/{reservation}', [CheckoutController::class, 'invoice'])->name('invoice');
    Route::get('/payments', [CheckoutController::class, 'paymentHistory'])->name('payments.index');

    // Refund Requests
    Route::get('/refunds', [UserRefundController::class, 'index'])->name('refunds.index');
    Route::get('/refunds/create', [UserRefundController::class, 'create'])->name('refunds.create');
    Route::post('/refunds', [UserRefundController::class, 'store'])->name('refunds.store');
});

// ==========================================
// ADMIN PROTECTED ROUTES
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin manages (Read-Update-Delete) user details
    Route::resource('users', AdminUserController::class)->except(['create', 'store']);

    // Admin manages (Create-Read-Update-Delete) hotel details
    Route::resource('hotels', AdminHotelController::class);

    // Admin manages (Create-Read-Update-Delete) flight details
    Route::resource('flights', AdminFlightController::class);

    // Admin manages (Create-Read-Update-Delete) package details
    Route::resource('packages', AdminPackageController::class);

    // Admin manages (Read-Update-Delete) user reservation details
    Route::resource('reservations', AdminReservationController::class)->except(['create', 'store']);

    // Admin manages (Create-Read-Update-Delete) refund details
    Route::resource('refunds', AdminRefundController::class);
});
