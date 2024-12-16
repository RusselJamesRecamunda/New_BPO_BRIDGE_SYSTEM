<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller; // Ensure base Controller is imported
use App\Models\Interviews; // Ensure the model is imported
use App\Models\JobCandidates;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Carbon\Carbon; // Include this line
use Illuminate\Support\Facades\Log;

class InterviewsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Handle AJAX for FullCalendar (existing logic)
            $interviews = Interviews::all(['interview_id', 'candidate_name', 'applied_job', 'interview_mode', 'email', 'phone', 'interview_date', 'interview_time','virtual_meet_link', 'onsite_phone']);
            $events = $interviews->map(function ($interview) {
                return [
                    'id' => $interview->interview_id,
                    'title' => $interview->candidate_name,
                    'start' => $interview->interview_date . 'T' . $interview->interview_time,
                    'applied_job' => $interview->applied_job, 
                    'interview_mode' => $interview->interview_mode,
                    'email' => $interview->email,
                    'phone' => $interview->phone,
                    'virtual_meet_link' => $interview->virtual_meet_link,
                    'onsite_phone' => $interview->onsite_phone
                ];
            });

            return response()->json($events);
        }

        // Pass qualified candidates to the view
        $qualifiedCandidates = JobCandidates::where('candidate_status', 'Qualified')->get();

        return view('admin.interviews', compact('qualifiedCandidates'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        //
    }

    // Store a new interview
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'candidate_name' => 'required|exists:job_candidates,candidate_id',  // Validate candidate_id exists in job_candidates table
            'applied_job' => 'required|string|max:255',
            'interview_mode' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'interview_date' => 'required|date',
            'interview_time' => 'required|string|max:5',
            'virtual_meet_link' => 'nullable|string|max:255',
            'onsite_phone' => 'nullable|string|max:100'
        ]);

        // Fetch candidate details by candidate_id
        $candidate = JobCandidates::find($request->input('candidate_name'));

        // Save the interview, ensuring both candidate_name and candidate_id are correctly stored
        $interview = new Interviews($validatedData);
        $interview->candidate_id = $candidate->candidate_id;  // Store candidate_id
        $interview->candidate_name = $candidate->candidate_name;  // Store candidate_name
        $interview->save();

        // Prepare details array with candidate_name instead of candidate_id
        $details = [
            'email' => $validatedData['email'],
            'candidate_name' => $candidate->candidate_name, // Use candidate_name from the database
            'applied_job' => $validatedData['applied_job'],
            'interview_date' => $validatedData['interview_date'],
            'interview_time' => $validatedData['interview_time'],
            'virtual_meet_link' => $validatedData['virtual_meet_link'],
            'onsite_phone' => $validatedData['onsite_phone'],
            'interview_mode' => $validatedData['interview_mode'],
        ];

        // Send interview notification email
        $this->sendInterviewNotification($details);

        return response()->json(['message' => 'Interview scheduled successfully!']);
    }

    // Send interview notification email
    private function sendInterviewNotification($details)
    {
        // Format the date and time using Carbon
        $details['interview_date'] = Carbon::parse($details['interview_date'])->format('F j, Y');
        $details['interview_time'] = Carbon::parse($details['interview_time'])->format('h:i A');
        
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
            $mail->Subject = 'Interview Invitation for ' . $details['applied_job'];

            // Attach images as embedded content
            $mail->addEmbeddedImage(public_path('asset/img/bpo_logo.png'), 'bpo_logo');

            // Fetch Blade template and CSS
            $htmlContent = view('admin.schedule-notification', $details)->render();
            $cssContent = file_get_contents(public_path('asset/css/interview-notification.css'));

            // Inline CSS
            $cssInliner = new CssToInlineStyles();
            $inlinedHtml = $cssInliner->convert($htmlContent, $cssContent);

            // Set the mail body with inlined styles
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
    public function show($id)
    {
        // Check if the request is an AJAX request
        if (!request()->ajax()) {
            abort(404);
        }
    
        // Validate the candidate_id format
        if (!is_numeric($id) || $id <= 0) {
            Log::error("Invalid candidate ID: {$id}");
            return response()->json(['error' => 'Invalid candidate ID'], 400);
        }
    
        // Fetch candidate details
        $candidate = JobCandidates::find($id);
    
        // Check if candidate exists
        if ($candidate) {
            // Return candidate details as JSON response
            return response()->json([
                'candidate_name' => $candidate->candidate_name,
                'applied_job' => $candidate->applied_job,
                'candidate_email' => $candidate->candidate_email,
                'candidate_phone' => $candidate->candidate_phone,
            ]);
        }
    
        // Log error if candidate not found
        Log::error("Candidate with ID {$id} not found");
        return response()->json(['error' => 'Candidate not found'], 404);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    // Update an existing interview
    public function update(Request $request, $id)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'applied_job' => 'required|string|max:255',
            'interview_mode' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'interview_date' => 'required|date',
            'interview_time' => 'required|date_format:H:i',
            'virtual_meet_link' => 'nullable|string|max:255', 
            'onsite_phone' => 'nullable|string|max:100'
        ]);

        $interview = Interviews::findOrFail($id);
        $interview->candidate_name = $request->candidate_name;
        $interview->applied_job = $request->applied_job;
        $interview->interview_mode = $request->interview_mode;
        $interview->email = $request->email;
        $interview->phone = $request->phone;
        $interview->interview_date = $request->interview_date;
        $interview->interview_time = $request->interview_time;
        $interview->virtual_meet_link = $request->virtual_meet_link;
        $interview->onsite_phone = $request->onsite_phone;
        $interview->save();

        // Return updated event data to the frontend
        return response()->json([
            'success' => true,
            'message' => 'Interview updated successfully.',
            'event' => [
                'id' => $interview->interview_id,
                'title' => $interview->candidate_name,
                'start' => $interview->interview_date . 'T' . $interview->interview_time,
                'applied_job' => $interview->applied_job,
                'interview_mode' => $interview->interview_mode,
                'email' => $interview->email,
                'phone' => $interview->phone,
                'virtual_meet_link' => $interview->virtual_meet_link,
                'onsite_phone' => $interview->onsite_phone,
            ]
        ]);
    }

    // Delete an interview
    public function destroy($id)
    {
        $interview = Interviews::findOrFail($id);
        $interview->delete();

        return response()->json(['success' => true, 'message' => 'Interview deleted successfully.']);
    }
}
