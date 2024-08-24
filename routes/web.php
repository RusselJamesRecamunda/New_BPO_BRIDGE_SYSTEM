<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GmailController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated and verified routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Gmail authentication routes
Route::get('auth/redirect', [GmailController::class, 'redirectToGoogle']);
Route::get('auth/callback', [GmailController::class, 'handleGoogleCallback']);

// Include additional authentication routes
require __DIR__.'/auth.php';
