<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

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
            'interview_mode',
            'phone',
            'resume_cv',
            'interview_date',
            'interview_notes',
            'interview_score',
            'result_status',
            'email'
        )->get();

        // Fetch only "Hired" candidates
        $hiredCandidates = InterviewResults::where('result_status', 'Hired')
            ->select('candidate_name', 'applied_job', 'email')
            ->get();

        // Pass both datasets to the view
        return view('admin.applicant-results', compact('interviewResults', 'hiredCandidates'));
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

    public function sendResultNotification(Request $request)
    {
        $request->validate([
            'candidate_name' => 'required|string',
            'applied_job' => 'required|string',
            'email' => 'required|email',
        ]);

        $details = [
            'candidate_name' => $request->candidate_name,
            'applied_job' => $request->applied_job,
            'email' => $request->email,
        ];

        try {
            $this->ResultNotification($details); // Call the private method
            return response()->json(['success' => true, 'message' => 'Email sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    // Send result notification email
    private function ResultNotification($details)
    {
        $mail = new PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = env('MAIL_PORT');
    
            // Set the sender's name to "BPO BRIDGE"
            $mail->setFrom('bpobridge2024@gmail.com', 'BPO BRIDGE');
            $mail->addAddress($details['email'], $details['candidate_name']);
    
            $mail->isHTML(true);
            $mail->Subject = 'Interview Result for ' . $details['applied_job'];
    
            // Attach images as embedded content
            $mail->addEmbeddedImage(public_path('asset/img/bpo_logo.png'), 'bpo_logo');
    
            // Render the Blade template and inline the CSS
            $htmlContent = view('admin.result-notification', $details)->render();
    
    
            // Inline the CSS using a library if necessary
            $cssInliner = new CssToInlineStyles();
            $inlinedHtml = $cssInliner->convert($htmlContent);
    
            // Set the inlined email body
            $mail->Body = $inlinedHtml;
    
            // Send the email
            $mail->send();
    
        } catch (Exception $e) {
            throw new \Exception("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
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
