<?php

namespace App\Http\Controllers\ApplicantControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\JobType;
use App\Models\FreelanceJobPosting;
use App\Models\FullTimeJobPosting;

class JobInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view(view: 'applicant.job-info');
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
    public function show($id, Request $request)
    {
        $jobType = $request->query('type');
        
        if ($jobType === 'full-time') {
            $job = FullTimeJobPosting::with('category', 'jobType')->where('full_job_ID', $id)->firstOrFail();
        } elseif ($jobType === 'freelance') {
            $job = FreelanceJobPosting::with('category', 'jobType')->where('fl_jobID', $id)->firstOrFail();
        } else {
            abort(404);
        }

        return view('applicant.job-info', compact('job'));
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
