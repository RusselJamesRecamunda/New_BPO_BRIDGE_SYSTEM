<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FullTimeJobPosting;
use App\Models\FreelanceJobPosting;
use App\Models\Applications;
use App\Models\JobCandidates;
use Illuminate\Support\Facades\Log;

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
    try {
        // Validate the incoming datad
        $validated = $request->validate([
            'application_id' => 'required|exists:applications,application_id', // Ensure the application exists
            'status' => 'required|in:Qualified,Not Qualified', // Validate the status
        ]);

        // Retrieve the application details
        $application = Applications::where('application_id', $validated['application_id'])->firstOrFail();

        // Determine the applied job title
        $appliedJobTitle = $application->full_job_ID
            ? FullTimeJobPosting::where('full_job_ID', $application->full_job_ID)->value('job_title') ?? 'Unknown Full-Time Job'
            : FreelanceJobPosting::where('fl_jobID', $application->fl_jobID)->value('fl_job_title') ?? 'Unknown Freelance Job';

        // Update or create the JobCandidates record
        JobCandidates::updateOrCreate(
            ['application_id' => $application->application_id], // Matching condition
            [
                'candidate_name' => $application->applicant_name,
                'candidate_email' => $application->applicant_email,
                'candidate_phone' => $application->applicant_phone,
                'applied_job' => $appliedJobTitle,
                'date_applied' => $application->app_date,
                'application_id' => $application->application_id,
                'application_status' => $application->application_status, // Sync application status
                'candidate_status' => $validated['status'], // The status from the request
                'candidate_resume' => $application->resume_cv,
                'candidate_cover_letter' => $application->cover_letter,
            ]
        );

        // Return a success response
        return response()->json(['message' => 'Candidate status updated successfully.'], 200);

    } catch (\Exception $e) {
        // Log the error and return an error response
        Log::error('Error updating candidate status: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update candidate status. Please try again.'], 500);
    }
}


    



    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        // Get job type from the query string
        $jobType = $request->query('type');
    
        // Fetch job and related applications based on the type and ID
        if ($jobType === 'full-time') {
            $job = FullTimeJobPosting::with('category', 'jobType')->where('full_job_ID', $id)->firstOrFail();
    
            // Fetch applications for this specific full-time job and group by the day of the week
            $applications = Applications::where('full_job_ID', $id)
                ->selectRaw('DAYOFWEEK(app_date) as day, COUNT(*) as count')
                ->groupBy('day')
                ->orderBy('day')
                ->get(); // Get the count of applications by day of the week
    
            // Fetch detailed application information separately
            $detailedApplications = Applications::where('full_job_ID', $id)
                ->select('application_id', 'applicant_name', 'application_status', 'resume_cv', 'cover_letter', 'app_date')
                ->get(); // Get the actual application details (non-grouped)
        } elseif ($jobType === 'freelance') {
            $job = FreelanceJobPosting::with('category', 'jobType')->where('fl_jobID', $id)->firstOrFail();
    
            // Fetch applications for this specific freelance job and group by the day of the week
            $applications = Applications::where('fl_jobID', $id)
                ->selectRaw('DAYOFWEEK(app_date) as day, COUNT(*) as count')
                ->groupBy('day')
                ->orderBy('day')
                ->get(); // Get the count of applications by day of the week
    
            // Fetch detailed application information separately
            $detailedApplications = Applications::where('fl_jobID', $id)
                ->select('application_id', 'applicant_name', 'application_status', 'resume_cv', 'cover_letter', 'app_date')
                ->get(); // Get the actual application details (non-grouped)
        } else {
            abort(404);
        }
    
        // Create a dataset for all days of the week
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $applicantData = array_fill(0, 7, 0);
    
        // Count applications by day of the week
        foreach ($applications as $application) {
            if ($application->day >= 1 && $application->day <= 7) { // Ensure valid day (1-7)
                $applicantData[$application->day - 1] = $application->count; // Populate counts for each day
            }
        }
    
        // Calculate total applicants this week
        $totalApplicantsThisWeek = array_sum($applicantData);

        // Count qualified candidates
        $qualifiedCount = JobCandidates::where('candidate_status', 'Qualified')->count();

        // Count pending candidates
        $pendingCount = Applications::where('application_status', 'Pending')->count();
    
        // Count all applications submitted 
        $appliedCount = Applications::count();

        // Pass data to the view
        return view('admin.overview-job', compact('job', 'jobType', 'applicantData', 'daysOfWeek', 'totalApplicantsThisWeek', 'detailedApplications', 'qualifiedCount', 'pendingCount', 'appliedCount'));
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
    public function update(Request $request, $id)
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
