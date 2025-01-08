<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminInfo; // Import the AdminInfo model
use App\Models\User; // Import the User model

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

            // Check if the user is an instance of User
            if (!($user instanceof User)) {
                return redirect()->back()->withErrors(['email' => 'User is not an instance of User model.']);
            }

            // Update activity status to 'Online'
            $user->activity_status = 'Online';
            $user->save(); // Save the user with updated activity status

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

            // Role-based redirection
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); 
            } elseif ($user->role === 'applicant') {
                return redirect()->route('home'); 
            }

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        // On failure, redirect back with an error message
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }
}
