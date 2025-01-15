<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'agree' => 'accepted',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate OTP
        // $otpCode = rand(100000, 999999);

        $table = $this->generateTable();
        $indices = $this->generateIndices();
        $otpCode = $this->generateOTP($table, $indices);

        // Store registration data in session
        $request->session()->put('registration_data', [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp_code' => $otpCode,
        ]);

        // Send OTP to email
        if (!$this->sendOtpEmail($request->email, $otpCode, $request->first_name)) {
            return redirect()->back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }

        return redirect()->route('verify-otp')->with('info', 'Please check your email for the OTP.');
    }

    // Method to send OTP email
    private function sendOtpEmail($email, $otpCode, $first_name)
    {
        $mail = new PHPMailer(true);

        try {
            // Load the Blade view from the 'auth' folder and pass the OTP code and first name
            $htmlContent = view('auth.email-otp', ['otpCode' => $otpCode, 'first_name' => $first_name])->render();

            // Load the CSS file from the public directory
            $cssContent = file_get_contents(public_path('asset/css/email-otp.css'));

            // Inline the CSS into the HTML using CssToInlineStyles
            $cssInliner = new CssToInlineStyles();
            $emailBody = $cssInliner->convert($htmlContent, $cssContent);

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
            $mail->Body    = $emailBody;

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
        return view('auth.verify-otp'); // Load the OTP form view
    }

    // OTP verification method// OTP verification method
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required',
        ]);

        $sessionData = $request->session()->get('registration_data');

        if (!$sessionData) {
            return response()->json(['success' => false, 'message' => 'No registration data found. Please register again.'], 400);
        }

        if ($sessionData['otp_code'] == $request->otp_code) {
            $user =  User::create([
                'first_name' => $sessionData['first_name'],
                'last_name' => $sessionData['last_name'],
                'email' => $sessionData['email'],
                'password' => $sessionData['password'],
                'email_verified_at' => now(),
                'role' => 'applicant',
            ]);

            $request->session()->forget('registration_data');

            $user->assignRole('applicant');

            return response()->json(['success' => true, 'message' => 'Successfully Registered New Account!']);
        }


        return response()->json(['success' => false, 'message' => 'Invalid OTP code. Please try again.'], 400);
    }

    public function generateTable()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $table = [];

        for ($i = 0; $i < 3; $i++) {
            $row = '';
            for ($j = 0; $j < 4; $j++) {
                $row .= $characters[rand(0, strlen($characters) - 1)];
            }
            $table[] = $row;
        }

        return $table;
    }

    public function generateIndices()
    {
        do {
            $index1 = rand(1, 4);
            $index2 = rand(1, 4);
        } while ($index1 == $index2);

        return [$index1, $index2];
    }

    public function generateOTP($table, $indices)
    {
        $otp = '';

        foreach ($indices as $index) {
            foreach ($table as $row) {
                $otp .= $row[$index - 1];
            }
        }

        return $otp;
    }
}
