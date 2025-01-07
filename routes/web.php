<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\AdminControllers\ApplicantTrackerController;
use App\Http\Controllers\AdminControllers\ApplicantResultsController;
use App\Http\Controllers\AdminControllers\InterviewNotesController;
use App\Http\Controllers\AdminControllers\EmployeeController;
use App\Http\Controllers\AdminControllers\AddEmployeeController;
use App\Http\Controllers\AdminControllers\DepartmentsController;
use App\Http\Controllers\AdminControllers\DepartmentInfoController;
use App\Http\Controllers\AdminControllers\JobsController;
use App\Http\Controllers\AdminControllers\OverviewJobController;
use App\Http\Controllers\AdminControllers\JobPostingController;
use App\Http\Controllers\AdminControllers\ApplicationsController;
use App\Http\Controllers\AdminControllers\ManageUsersController;
use App\Http\Controllers\AdminControllers\InterviewsController;
use App\Http\Controllers\AdminControllers\ScheduleNotificationController;
use App\Http\Controllers\AdminControllers\ResultNotificationController;
use App\Http\Controllers\AdminControllers\ReportsController;

use App\Http\Controllers\ApplicantControllers\ApplicantProfileController;
use App\Http\Controllers\ApplicantControllers\AboutUsController;
use App\Http\Controllers\ApplicantControllers\JobInfoController;
use App\Http\Controllers\ApplicantControllers\ApplicationFormController;
use App\Http\Controllers\ApplicantControllers\ManageProfileController;
use App\Http\Controllers\ApplicantControllers\ContactUsController;
use App\Http\Controllers\ApplicantControllers\ApplySuccessController;
use App\Http\Controllers\ApplicantControllers\AppliedSavedController;
use App\Http\Controllers\ApplicantControllers\RecruitmentSubmissionController;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/', [JobsController::class, 'index'])->name('home')->defaults('forHome', true);

require __DIR__ . '/auth.php';

// Zoom Meeting Creation
// Route::post('generate-meet-link', [ZoomMeetingController::class, 'generateMeetingLink'])->name('generate.meet.link');

Route::middleware(['guest'])->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('verify-otp', [RegisterController::class, 'showOtpForm'])->name('verify-otp');
    Route::post('verify-otp', [RegisterController::class, 'verifyOtp']);

    // Login Session
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// routes for BPO sidebar
Route::get('/sidebar', function () {
    return view('components.sidebar');
});

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        // This should match the logout action defined in your controller
        // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::group(
            ['middleware' => 'role:applicant'],
            function () {
                Route::prefix('applicant')->group(function () {
                    Route::get('dashboard', [ApplicantController::class, 'index'])->name('applicant.index');

                    // Profile View and Controller
                    Route::resource('profile-page', ApplicantProfileController::class);

                    // About Us View and Controller
                    Route::resource('about-us', AboutUsController::class);

                    // Manage Profile View and Controller
                    Route::resource('manage-profile', ManageProfileController::class);
                    // Route for both guests and authenticated users
                    Route::get('manage-profile', [ManageProfileController::class, 'index'])->name('manage-profile.index');
                    // Route for authenticated users only (middleware applied here)
                    Route::post('manage-profile', [ManageProfileController::class, 'update'])->name('manage-profile.update')->middleware('auth');
                    Route::post('manage-profile', [ManageProfileController::class, 'updateContents'])->name('profileContents.update')->middleware('auth');

                    // To Edit Profile View
                    Route::post('manage-profile/updateOrCreate', [ManageProfileController::class, 'updateOrCreate'])->name('manage-profile.updateOrCreate');

                    // Contact Us View and Controller
                    Route::resource('contact-us', ContactUsController::class);

                    // About Us View and Controller
                    Route::resource('job-info', JobInfoController::class);

                    // Application Form View and Controller
                    Route::resource('application-form', ApplicationFormController::class);
                    Route::resource('thank-you', ApplySuccessController::class);

                    // Applied-Saved View and Controller
                    Route::resource('applied-saved', AppliedSavedController::class);
                });
            }
        );

        Route::group(['middleware' => 'role:admin'], function () {
            Route::prefix('admin')->group(function () {
                Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

                // Dashboard View and Controller
                // Route::resource('dashboard', DashboardController::class);

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
                Route::resource('overview-job', OverviewJobController::class);
                Route::resource('job-posting', JobPostingController::class);

                // Route for editing a job posting
                Route::get('/admin/job-posting/{id}/edit', [JobPostingController::class, 'edit'])->name('job-posting.edit');
                Route::put('/admin/job-posting/{job_posting}', [JobPostingController::class, 'update'])->name('job-posting.update');


                Route::resource('applications', ApplicationsController::class);
                // Custom updateStatus route
                Route::patch('applications/{application}/updateStatus', [ApplicationsController::class, 'updateStatus'])->name('applications.updateStatus');
                // Define the route for exporting applications
                Route::get('/admin/applications/export', [ApplicationsController::class, 'exportApplications'])->name('applications.exportApplications');

                // Users View and Controller
                Route::resource('users', ManageUsersController::class);

                //Interviews View and Controller
                Route::resource('interviews', InterviewsController::class);

                // This creates routes for all standard resource actions
                Route::resource('schedule-notification', ScheduleNotificationController::class);
                Route::resource('result-notification', ResultNotificationController::class);
                Route::post('/admin/send-result-notification', [ApplicantResultsController::class, 'sendResultNotification'])->name('admin.send-result-notification');

                //General Reports View and Controller
                Route::resource('reports', ReportsController::class);
            });
        });
    }
);
