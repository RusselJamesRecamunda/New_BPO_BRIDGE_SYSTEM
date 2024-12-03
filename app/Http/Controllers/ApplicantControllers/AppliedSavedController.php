<?php

namespace App\Http\Controllers\ApplicantControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavedJobs;
use App\Models\Applications;
use Illuminate\Support\Facades\Auth;

class AppliedSavedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $savedJobs = SavedJobs::where('user_id', Auth::id())
            ->with(['fullTimeJob', 'freelanceJob'])
            ->get();

        $appliedJobs = Applications::where('user_id', Auth::id())
            ->with(['fullTimeJobPosting', 'freelanceJobPosting'])
            ->get();

        return view('applicant.applied-saved', compact('savedJobs', 'appliedJobs'));
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
    public function show(string $id)
    {
        //
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
    public function destroy(Request $request, $id = null)
    {
        // If $id is provided via the URL, use it, otherwise fallback to request input
        $save_ID = $id ?? $request->input('save_ID');
    
        // Validate save_ID
        if (!$save_ID) {
            return response()->json(['success' => false, 'message' => 'Missing save_ID!'], 400);
        }
    
        // Check if the job exists and delete it
        $savedJob = SavedJobs::find($save_ID);
    
        if ($savedJob) {
            $savedJob->delete();
            return response()->json(['success' => true, 'message' => 'Job deleted successfully!']);
        }
    
        return response()->json(['success' => false, 'message' => 'Job not found!'], 404);
    }
}
