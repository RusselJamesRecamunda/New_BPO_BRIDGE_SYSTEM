<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegisterController extends Controller
{
    // Method to show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register'); // Load the registration form view
    }

    // Registration method to handle form submission
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'agree' => 'accepted', // Ensure agreement checkbox is checked
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate OTP
        $otpCode = rand(100000, 999999);

        // Store registration data in session
        $request->session()->put('registration_data', [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp_code' => $otpCode,
        ]);

        // Send OTP to email
        if (!$this->sendOtpEmail($request->email, $otpCode)) {
            return redirect()->back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }

        return redirect()->route('verify-otp')->with('info', 'Please check your email for the OTP.'); // Change success message to info
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

            $mail->setFrom('bpobridge2024@gmail.com', 'BPO Bridge System OTP Code');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "Your OTP code is: <b>$otpCode</b>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            \Log::error("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    // Method to show OTP verification form
    public function showOtpForm()
    {
        return view('auth.verify-otp'); // Load the OTP form view
    }

    // OTP verification method// OTP verification method
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric',
        ]);

        $sessionData = $request->session()->get('registration_data');

        if (!$sessionData) {
            return response()->json(['success' => false, 'message' => 'No registration data found. Please register again.'], 400);
        }

        if ($sessionData['otp_code'] == $request->otp_code) {
            // Create new user account
            User::create([
                'email' => $sessionData['email'],
                'password' => $sessionData['password'],
                'email_verified_at' => now(), // Set email verification time
                'role' => 'applicant',
            ]);

            $request->session()->forget('registration_data');

            // Return success response
            return response()->json(['success' => true, 'message' => 'Successfully Registered New Account!']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid OTP code. Please try again.'], 400);
    }
}
