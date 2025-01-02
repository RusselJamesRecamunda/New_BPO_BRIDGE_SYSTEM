<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetOTPController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

// Group for Password Reset with OTP
Route::middleware('guest')->group(function () {
    // Forgot Password: Request OTP
    Route::get('/forgot-password', [PasswordResetOTPController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetOTPController::class, 'store'])->name('password.email');

    // Verify OTP
    Route::get('/verify-otp-reset', [PasswordResetOTPController::class, 'showOtpForm'])->name('password.otp');
    Route::post('/verify-otp-reset', [PasswordResetOTPController::class, 'verifyOtp'])->name('password.verify.otp');

    // Password Reset: Display form and update password
    Route::get('/otp-reset-password', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/otp-reset-password', [NewPasswordController::class, 'store'])->name('password.update'); // Ensure this route is named
});



Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
