<?php

namespace App\Http\Controllers\ApplicantControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FullTimeJobPosting;
use App\Models\FreelanceJobPosting;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($application_form, Request $request)
    {
        $jobType = $request->query('type'); // Get the job type from the query string
    
        // Fetch the job based on the application_form (job_id)
        if ($jobType === 'full-time') {
            $job = FullTimeJobPosting::where('full_job_ID', $application_form)->firstOrFail();
        } elseif ($jobType === 'freelance') {
            $job = FreelanceJobPosting::where('fl_jobID', $application_form)->firstOrFail();
        } else {
            return abort(404); // If type is invalid
        }
    
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
