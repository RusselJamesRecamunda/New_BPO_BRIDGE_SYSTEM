<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\InterviewResults;

class ApplicantResultsController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all interview results
        $interviewResults = InterviewResults::select(
            'candidate_name',
            'applied_job',
            'interviewer',
            'interviewer',
            'interview_mode',
            'phone',
            'resume_cv',
            'interview_date',
            'interview_notes',
            'interview_score',
            'result_status'
        )->get();

        // Return the view with all interview results
        return view('admin.applicant-results', compact('interviewResults'));
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
        // Validate the incoming request
        $validatedData = $request->validate([
            'candidate_name' => 'required|string',
            'interview_score' => 'required|numeric',
            'result_status' => 'required|string',
            'interviewer' => 'required|string',
            'interview_notes' => 'required|string',
        ]);

        // Store or update the evaluation result
        InterviewResults::updateOrCreate(
            ['candidate_name' => $validatedData['candidate_name']],
            [
                'interview_score' => $validatedData['interview_score'],
                'result_status' => $validatedData['result_status'],
                'interviewer' => $validatedData['interviewer'],
                'interview_notes' => $validatedData['interview_notes'],
            ]
        );

        // Return a response indicating success
        return response()->json(['success' => true, 'message' => 'Interview result updated/created successfully']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the interview result by ID
        $interviewResult = InterviewResults::select(
            'candidate_name',
            'applied_job',
            'interviewer',
            'interview_mode',
            'phone',
            'resume_cv',
            'interview_date',
            'interview_notes',
            'interview_score',
            'result_status'
        )->findOrFail($id);
    
        // Redirect back to index with the selected result highlighted (optional)
        return redirect()->route('applicant-results.index')->with('interviewResult', $interviewResult);
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
