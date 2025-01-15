<?php

namespace App\Http\Controllers\ApplicantControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentSubmission;
use App\Models\InterviewResults;
use App\Models\User;

class RecruitmentSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch query parameters from the URL
        $candidateName = $request->query('candidate_name', ''); // Default to empty string if not provided
        $email = $request->query('email', '');

        // Pass the variables to the view
        return view('applicant.recruitment-submission', compact('candidateName', 'email'));
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
            $validated = $request->validate([
                'email' => 'required|email|max:255|exists:users,email',
                '2x2_pic' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
                'birth_certificate' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
                'tin_number' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
                'philhealth_id' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
                'pagibig_membership_id' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
                'sss' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
                'bir_form' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
                'health_cert' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
            ]);

            // Simulate an error scenario for demonstration (e.g., email not found)
            $interviewResult = InterviewResults::where('email', $request->email)
                ->where('result_status', 'Hired')
                ->first();

            if (!$interviewResult) {
                // Redirect back with an error message
                return redirect()
                    ->route('recruitment-submission.index')
                    ->with('error', 'Failed to submit: email not found in Interview Results.');
            }

            // Retrieve the authenticated user
            $user = User::where('email', $request->email)->first();

            // Document Submission Uploads
            $documentPaths = [
                '2x2_pic' => 'recruitment-submission/2x2-Photo',
                'birth_certificate' => 'recruitment-submission/Birth-Certificate',
                'tin_number' => 'recruitment-submission/Tin-Number',
                'philhealth_id' => 'recruitment-submission/Philhealth-ID',
                'pagibig_membership_id' => 'recruitment-submission/Pag-Ibig-Number',
                'sss' => 'recruitment-submission/SSS',
                'bir_form' => 'recruitment-submission/BIR-Form',
                'health_cert' => 'recruitment-submission/Health-Certificate',
            ];

            $documentFiles = [];

            foreach ($documentPaths as $inputName => $path) {
                if ($request->hasFile($inputName)) {
                    $file = $request->file($inputName);
                    $fileName = uniqid() . '.' . $file->getClientOriginalExtension(); // Unique file name
                    $documentFiles[$inputName] = $file->storeAs($path, $fileName, 'public');
                } else {
                    $documentFiles[$inputName] = null; // In case no file was uploaded for this document
                }
            }

            // Create Document Submission Record
            DocumentSubmission::create([
                'user_id' => $user->user_id,
                'result_id' => $interviewResult->result_id,
                '2x2_pic' => $documentFiles['2x2_pic'],
                'birth_certificate' => $documentFiles['birth_certificate'],
                'tin_number' => $documentFiles['tin_number'],
                'philhealth_id' => $documentFiles['philhealth_id'],
                'pagibig_membership_id' => $documentFiles['pagibig_membership_id'],
                'sss' => $documentFiles['sss'],
                'bir_form' => $documentFiles['bir_form'],
                'health_cert' => $documentFiles['health_cert'],
            ]);

            // Set a success message in the session
        session()->flash('success', 'Your documents have been successfully submitted. Please wait for further instructions as we review your submission.');
            // Redirect back to the home route
            return redirect()->route('home');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Flash validation errors and redirect back
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Flash general error message and redirect back
            return redirect()->back()->with('error', 'An error occurred. Please try again.')->withInput();
        }
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
    public function destroy(string $id)
    {
        //
    }
}
