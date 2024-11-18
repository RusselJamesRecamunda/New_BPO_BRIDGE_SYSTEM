<?php

namespace App\Http\Controllers\ApplicantControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavedJobs;
use Illuminate\Support\Facades\Auth;

class AppliedSavedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the saved jobs for the logged-in user
        $savedJobs = SavedJobs::where('user_id',  Auth::id())
            ->with(['fullTimeJob', 'freelanceJob']) // Eager load relationships
            ->get();

        // Pass saved jobs to the view
        return view('applicant.applied-saved', compact('savedJobs'));
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
    public function destroy(Request $request)
    {
        // Validate the request to ensure the save_ID is provided
        $request->validate([
            'save_ID' => 'required|exists:saved_jobs,save_ID',
        ]);
    
        // Find and delete the saved job
        $savedJob = SavedJobs::find($request->save_ID);
    
        if ($savedJob) {
            $savedJob->delete();
            return response()->json(['success' => true, 'message' => 'Job deleted successfully!']);
        }
    
        return response()->json(['success' => false, 'message' => 'Job not found!'], 404);
    }
    
}
