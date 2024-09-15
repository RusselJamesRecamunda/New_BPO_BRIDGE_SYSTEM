<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GmailController;
use App\Http\Controllers\AdminContentController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Admin Dashboard route (accessible without login)
Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');

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

// routes for BPO sidebar
Route::get('/sidebar', function () {
    return view('components.sidebar');
});

// Updated routes using the AdminContentController method
Route::get('/applicant-tracker', [AdminContentController::class, 'showContent'])->name('applicant.tracker')->defaults('type', 'applicant-tracker');
Route::get('/applicant-result', [AdminContentController::class, 'showContent'])->name('admin.applicant_results')->defaults('type', 'applicant-result');
Route::get('/admin/notes', [AdminContentController::class, 'showContent'])->name('admin.notes')->defaults('type', 'notes');
Route::get('/admin/employees', [AdminContentController::class, 'showContent'])->name('admin.employees')->defaults('type', 'employees');
Route::get('/admin/departments', [AdminContentController::class, 'showContent'])->name('admin.departments')->defaults('type', 'departments');
Route::get('/admin/jobs', [AdminContentController::class, 'showContent'])->name('admin.jobs')->defaults('type', 'jobs');
Route::get('/admin/job-posting', [AdminContentController::class, 'showContent'])->name('admin.job-posting')->defaults('type', 'job-posting');
Route::get('/admin/applications', [AdminContentController::class, 'showContent'])->name('admin.applications')->defaults('type', 'applications');
Route::get('/admin/users', [AdminContentController::class, 'showContent'])->name('admin.users')->defaults('type', 'users');
Route::get('/admin/interviews', [AdminContentController::class, 'showContent'])->name('admin.interviews')->defaults('type', 'interviews');

// Include additional authentication routes
require __DIR__.'/auth.php';
