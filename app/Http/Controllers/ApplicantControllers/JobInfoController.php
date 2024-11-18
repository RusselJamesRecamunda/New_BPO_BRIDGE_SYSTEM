<?php

namespace App\Http\Controllers\ApplicantControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavedJobs;
use App\Models\FreelanceJobPosting;
use App\Models\FullTimeJobPosting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        // Validate request
        $request->validate([
            'job_id' => 'required|integer',
            'job_type' => 'required|string|in:full-time,freelance',
        ]);
    
        try {
            $userId = Auth::id(); // Get logged-in user ID
    
            // Prepare data based on job type
            $data = [
                'user_id' => $userId,
                'job_type_name' => $request->job_type,
            ];
    
            // Associate correct job ID
            if ($request->job_type === 'full-time') {
                $data['full_job_id'] = $request->job_id;
            } elseif ($request->job_type === 'freelance') {
                $data['fl_job_id'] = $request->job_id;
            }
    
            // Check if the job is already saved
            $exists = SavedJobs::where('user_id', $userId)
                ->where($request->job_type === 'full-time' ? 'full_job_id' : 'fl_job_id', $request->job_id)
                ->exists();
    
            if ($exists) {
                return response()->json(['success' => false, 'message' => 'This job is already saved.']);
            }
    
            // Save job to the database
            SavedJobs::create($data);
    
            return response()->json(['success' => true, 'message' => 'Job saved successfully!']);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error saving job: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while saving the job.']);
        }
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
        return view('applicant.job-info', compact('job', 'jobType'));
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
