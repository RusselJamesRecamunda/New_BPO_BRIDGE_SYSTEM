<?php

namespace App\Http\Controllers\ApplicantControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications;
use App\Models\User;
use App\Models\FullTimeJobPosting;
use App\Models\FreelanceJobPosting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ApplicationFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view(view: 'applicant.application-form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request) 
    {
        $user = Auth::user(); // Get the currently logged-in user
    
        // Retrieve jobType and jobId from the request
        $jobType = $request->input('jobType');
        $jobId = $request->input('jobId');
    
        // Debugging: Log jobType and jobId for verification
        Log::info('Job Type: ' . $jobType);
        Log::info('Job ID: ' . $jobId);
    
        // Ensure jobType and jobId are provided
        if (!$jobType || !$jobId) {
            return redirect()->back()->with('error', 'Job Type and Job ID are required.');
        }

         // Check if the user has already applied for this job
    $existingApplication = Applications::where('user_id', $user->user_id)
    ->where(function ($query) use ($jobType, $jobId) {
        if ($jobType === 'full-time') {
            $query->where('full_job_ID', $jobId);
        } elseif ($jobType === 'freelance') {
            $query->where('fl_jobID', $jobId);
        }
    })->first();

if ($existingApplication) {
    return redirect()->back()->with('error', 'You have already applied for this job.');
}
    
        // Variables for job type and category names
        $jobTypeName = '';
        $categoryName = '';
        $jobTypeId = null;
        $categoryId = null;
    
        // Handle full-time and freelance jobs based on jobType
        if ($jobType === 'full-time') {
            // Fetch the full-time job
            $job = FullTimeJobPosting::findOrFail($jobId);
            $jobTypeId = $job->job_type_id;
            $categoryId = $job->category_id;
            $jobTypeName = $job->jobType->job_type_name ?? '';
            $categoryName = $job->category->category_name ?? '';
        } elseif ($jobType === 'freelance') {
            // Fetch the freelance job
            $job = FreelanceJobPosting::findOrFail($jobId);
            $jobTypeId = $job->fl_job_type_id;
            $categoryId = $job->fl_category_id;
            $jobTypeName = $job->jobType->job_type_name ?? '';
            $categoryName = $job->category->category_name ?? '';
        }
    
        // Handle file uploads for resume and cover letter
        $resume = $request->file('resume');
        $coverLetter = $request->file('coverLetter');
    
        // Store file paths in the public storage folder
        $resumePath = $resume->storeAs('public/applicant-files', $resume->getClientOriginalName());
        $coverLetterPath = $coverLetter ? $coverLetter->storeAs('public/applicant-files', $coverLetter->getClientOriginalName()) : null;
    
        // Debugging: Verify storage paths
        Log::info('Resume Path: ' . $resumePath);
        if ($coverLetterPath) {
            Log::info('Cover Letter Path: ' . $coverLetterPath);
        }
    
        // Store the application data in the applications table
        Applications::create([
            'app_date' => now(),
            'applicant_name' => $request->input('firstName') . ' ' . $request->input('lastName'),
            'applicant_email' => $request->input('email'),
            'applicant_phone' => $request->input('phone'),
            'applicant_location' => $request->input('address'),
            'applicant_emp_status' => $request->input('employmentStatus'),
            'job_type' => $jobTypeName,
            'job_category' => $categoryName,
            'resume_cv' => $resumePath,
            'cover_letter' => $coverLetterPath,
            'application_status' => 'In Process',
            'user_id' => $user->user_id,
            'full_job_ID' => $jobType === 'full-time' ? $jobId : null, // Assign based on jobType
            'fl_jobID' => $jobType === 'freelance' ? $jobId : null,   // Assign based on jobType
        ]);
    
        // Debugging: Confirm data storage
        Log::info('Application stored successfully.');
    
        // Redirect back to the application form with a success message
        return redirect()->route('thank-you.index')->with('success', 'Application submitted successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($application_form, Request $request)
    {
        // Get the job type from the query string
        $jobType = $request->query('type');
        $user = Auth::user(); // Get the logged-in user

        // Fetch the job based on the application_form (job_id)
        $job = null;
        if ($jobType === 'full-time') {
            $job = FullTimeJobPosting::where('full_job_ID', $application_form)->firstOrFail();
        } elseif ($jobType === 'freelance') {
            $job = FreelanceJobPosting::where('fl_jobID', $application_form)->firstOrFail();
        } else {
            return abort(404); // If type is invalid
        }

        // Check if the user has already applied for this job
        if ($user) {
            $existingApplication = Applications::where('user_id', $user->user_id)
                ->where(function ($query) use ($jobType, $application_form) {
                    if ($jobType === 'full-time') {
                        $query->where('full_job_ID', $application_form);
                    } elseif ($jobType === 'freelance') {
                        $query->where('fl_jobID', $application_form);
                    }
                })->first();

            if ($existingApplication) {
                // Redirect back with an error message
                return redirect()->back()->with('error', 'You have already applied for this job.');
            }
        }

        // Return the application form view if no application exists
        return view('applicant.application-form', compact('job', 'jobType'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
