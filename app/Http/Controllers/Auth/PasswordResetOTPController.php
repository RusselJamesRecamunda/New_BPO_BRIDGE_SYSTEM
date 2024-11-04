<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Validator;

class PasswordResetOTPController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
        public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Generate OTP
        $otpCode = rand(100000, 999999); // Replace with your OTP generation logic

        // Store OTP in session
        $request->session()->put('otp_data', [
            'email' => $request->email,
            'otp_code' => $otpCode,
        ]);

        // Send OTP to email
        if (!$this->sendOtpEmail($request->email, $otpCode)) {
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }

        // Redirect to the OTP verification page with a success message
        return redirect()->route('password.otp')->with('info', 'Please check your email for the OTP.');
    }


    // Method to send OTP email
    private function sendOtpEmail($email, $otpCode)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'bpobridge2024@gmail.com';
            $mail->Password   = 'rzwljflcpbjpsewr'; // Replace with a valid SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('bpobridge2024@gmail.com', 'BPO Bridge OTP Code');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "Your OTP code is: <b>$otpCode</b>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            Log::error("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    // Method to show OTP verification form
    public function showOtpForm()
    {
        return view('auth.verify-otp-reset'); // Load the OTP form view
    }

    // OTP verification method
    public function verifyOtp(Request $request)
    {
        // Validate the OTP
        $validator = Validator::make($request->all(), [
            'otp_code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP format.']);
        }

        $otpCode = $request->input('otp_code');
        $sessionOtp = $request->session()->get('otp_data.otp_code');
        $email = $request->session()->get('otp_data.email');

        // Check if OTP is correct
        if ($otpCode == $sessionOtp) {
            // Store the email in session under 'reset_email' for retrieval in blade
            $request->session()->put('reset_email', $email);

            return response()->json(['success' => true, 'email' => $email]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid OTP']);
        }
    }
}
