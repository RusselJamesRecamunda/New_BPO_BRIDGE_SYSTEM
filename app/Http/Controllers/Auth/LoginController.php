<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminInfo; // Import the AdminInfo model

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login'); // Adjust to the correct path if needed
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Verify the user's email and password using Auth::attempt
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // If the user role is admin, verify the presence in the admin_info table
            if ($user->role === 'admin') {
                // Check if the admin_info record exists for this user
                $adminInfo = AdminInfo::where('user_id', $user->user_id)->first();

                if (!$adminInfo) {
                    // If no admin_info entry exists, log the user out and return an error
                    Auth::logout();
                    return redirect()->back()->withErrors(['email' => 'Admin verification failed.']);
                }
            }

            // Role-based redirection (no changes required here)
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); 
            } elseif ($user->role === 'applicant') {
                return redirect()->route('applicant.index'); 
            }
        }

        // On failure, redirect back with an error message
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }
}
