<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller; // Ensure base Controller is imported
use App\Models\Interviews; // Ensure the model is imported
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Carbon\Carbon; // Include this line

class InterviewsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch and return data for FullCalendar when called via AJAX
            $interviews = Interviews::all(['interview_id', 'candidate_name', 'applied_job', 'interview_mode', 'email', 'phone', 'interview_date', 'interview_time','zoom_link']);
            
            $events = $interviews->map(function ($interview) {
                return [
                    'id' => $interview->interview_id,
                    'title' => $interview->candidate_name,
                    'start' => $interview->interview_date . 'T' . $interview->interview_time,
                    'applied_job' => $interview->applied_job, 
                    'interview_mode' => $interview->interview_mode,
                    'email' => $interview->email,
                    'phone' => $interview->phone,
                    'zoom_link' => $interview->zoom_link,
                ];
            });

            return response()->json($events); // Return JSON response for FullCalendar
        }

        // Render the interviews view when not an AJAX request
        return view('admin.interviews');
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
            'candidate_name' => 'required|string|max:255',
            'applied_job' => 'required|string|max:255',
            'interview_mode' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'interview_date' => 'required|date',
            'interview_time' => 'required|string|max:5',
            'zoom_link' => 'nullable|string|max:255', 
        ]);

        // Save the interview
        $interview = new Interviews($validatedData);
        $interview->save();

        // Send interview notification email
        $this->sendInterviewNotification($validatedData);

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
            $mail->addEmbeddedImage(public_path('asset/img/congrats.gif'), 'congrats');

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
            'zoom_link' => 'nullable|string|max:255', // Modified to make zoom_link optional
        ]);

        $interview = Interviews::findOrFail($id);
        $interview->candidate_name = $request->candidate_name;
        $interview->applied_job = $request->applied_job;
        $interview->interview_mode = $request->interview_mode;
        $interview->email = $request->email;
        $interview->phone = $request->phone;
        $interview->interview_date = $request->interview_date;
        $interview->interview_time = $request->interview_time;
        $interview->zoom_link = $request->zoom_link;
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
                'zoom_link' => $interview->zoom_link,
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
