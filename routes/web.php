<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
use App\Http\Controllers\AdminControllers\ScheduleNotificationController;
use App\Http\Controllers\AdminControllers\ReportsController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('verify-otp', [RegisterController::class, 'showOtpForm'])->name('verify-otp');
Route::post('verify-otp', [RegisterController::class, 'verifyOtp']);
 
// Login Session
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// This should match the logout action defined in your controller
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Admin Dashboard 
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// Applicant Page
Route::get('/applicant/dashboard', [ApplicantController::class, 'index'])->name('applicant.index');

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
    
    // This creates routes for all standard resource actions
    Route::resource('schedule-notification', ScheduleNotificationController::class);
    //General Reports View and Controller
    Route::resource('reports', ReportsController::class);
});


