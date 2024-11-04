<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = Auth::user(); // Retrieve the authenticated user

        // Check if the user is an instance of User
        if (!$user instanceof User) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }

        // Update activity status to 'Online'
        $user->activity_status = 'Online';
        $user->save(); // Save the user with updated activity status

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user(); // Retrieve the authenticated user

        // Update activity status to 'Offline' if user is logged in
        if ($user instanceof User) {
            $user->activity_status = 'Offline';
            $user->save(); // Save the user with updated activity status
        }

        Auth::logout();  // Logout user
        $request->session()->invalidate();  // Invalidate session
        $request->session()->regenerateToken();  // Regenerate CSRF token

        return redirect()->route('welcome');  // Redirect to welcome page
    }
}
