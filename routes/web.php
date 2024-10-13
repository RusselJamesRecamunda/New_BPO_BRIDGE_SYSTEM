<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminControllers\ApplicantTrackerController;
use App\Http\Controllers\AdminControllers\ApplicantResultsController;
use App\Http\Controllers\AdminControllers\InterviewNotesController;
use App\Http\Controllers\AdminControllers\EmployeeController;
use App\Http\Controllers\AdminControllers\AddEmployeeController;
use App\Http\Controllers\AdminControllers\DepartmentsController;
use App\Http\Controllers\AdminControllers\DepartmentInfoController;
use App\Http\Controllers\AdminControllers\JobsController;
use App\Http\Controllers\AdminControllers\JobPostingController;
use App\Http\Controllers\AdminControllers\ApplicationsController;
use App\Http\Controllers\AdminControllers\ManageUsersController;
use App\Http\Controllers\AdminControllers\InterviewsController;
use App\Http\Controllers\AdminControllers\ReportsController;

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


// routes for BPO sidebar
Route::get('/sidebar', function () {
    return view('components.sidebar');
});


Route::prefix('admin')->group(function () {

    // Applicant Tracker View and Controller
    Route::resource('applicant-tracker', ApplicantTrackerController::class);
    Route::resource('applicant-results', ApplicantResultsController::class);
    Route::resource('notes', InterviewNotesController::class);

    // Employees View and Controller 
    Route::resource('employees', EmployeeController::class);
    Route::resource('add-employee', AddEmployeeController::class);
    Route::resource('departments', DepartmentsController::class);
    Route::resource('department-info', DepartmentInfoController::class);
    
    // Jobs View and Controller
    Route::resource('jobs', JobsController::class);
    Route::resource('job-posting', JobPostingController::class);
    Route::resource('applications', ApplicationsController::class);

    // Users View and Controller
    Route::resource('users', ManageUsersController::class);

    //Interviews View and Controller
    Route::resource('interviews', InterviewsController::class);
    Route::get('interviews/fetch', [InterviewsController::class, 'fetch'])->name('interviews.fetch');


    //General Reports View and Controller
    Route::resource('reports', ReportsController::class);
});

// Include additional authentication routes
require __DIR__.'/auth.php';
