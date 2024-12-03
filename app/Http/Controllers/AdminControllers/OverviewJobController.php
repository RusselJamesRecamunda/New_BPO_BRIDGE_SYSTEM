<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FullTimeJobPosting;
use App\Models\FreelanceJobPosting;

class OverviewJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view(view: 'admin.overview-job');
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
        // Get job type from the query string
        $jobType = $request->query('type');

        // Fetch job based on the type and ID
        if ($jobType === 'full-time') {
            $job = FullTimeJobPosting::with('category', 'jobType')->where('full_job_ID', $id)->firstOrFail();
        } elseif ($jobType === 'freelance') {
            $job = FreelanceJobPosting::with('category', 'jobType')->where('fl_jobID', $id)->firstOrFail();
        } else {
            abort(404);
        }

        // Pass both job and jobType to the view
        return view('admin.overview-job', compact('job', 'jobType'));
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
