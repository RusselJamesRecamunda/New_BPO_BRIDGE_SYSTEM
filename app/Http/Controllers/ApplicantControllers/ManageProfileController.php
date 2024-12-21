<?php

namespace App\Http\Controllers\ApplicantControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ManageProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Pass the authenticated user data to the view
            $user = Auth::user();
            return view('applicant.manage-profile', compact('user'));
        }
    
        // Render the guest view
        return view('applicant.manage-profile');
    }    


    public function update(Request $request, $id)
    {
        // Log request for debugging
        Log::info("Updating profile photo for user ID: " . $id);
    
        // Validate the uploaded file
        $request->validate([
            'user_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Check if the request contains a file
        if ($request->hasFile('user_photo')) {
            // Log file upload attempt
            Log::info("File uploaded: " . $request->file('user_photo')->getClientOriginalName());
    
            $file = $request->file('user_photo');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store the file in the designated folder
            $file->storeAs('public/user-photos', $fileName);
            Log::info("File stored as: " . $fileName);
    
            // Delete the old profile photo if it exists
            if ($user->user_photo && Storage::exists('public/user-photos/' . $user->user_photo)) {
                Log::info("Deleting old profile photo: " . $user->user_photo);
                Storage::delete('public/user-photos/' . $user->user_photo);
            }
    
            // Update the user's profile photo column
            $user->user_photo = $fileName;
            $user->save();
            
            // Log successful update
            Log::info("Profile photo updated successfully for user ID: " . $id);
    
            // Return the URL of the new image
            return response()->json([
                'success' => true,
                'imageUrl' => asset('storage/user-photos/' . $fileName),
            ]);
        }
    
        // Log error if no file is uploaded
        Log::warning("No file uploaded for user ID: " . $id);
    
        return response()->json(['success' => false, 'error' => 'No file uploaded']);
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function updateOrCreate(Request $request)
    {
        $user = Auth::user();
    
        // Ensure user is logged in and is an instance of User
        if (!$user || !($user instanceof User)) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
        }
    
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|regex:/^\d{10}$/', // Exactly 10 digits for phone number input
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
        ]);
    
        // Append the +63 prefix to the phone number
        $phoneNumber = $request->input('phone_number');
        if ($phoneNumber) {
            $phoneNumber = '+63' . $phoneNumber; // Prepend +63 prefix
        }
    
        // Manually update the fields
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address', 'N/A');
        $user->phone_number = $phoneNumber; // Save phone number with +63 prefix
        $user->email = $request->input('email');
    
        // Save the changes
        if ($user->save()) {
            return redirect()->route('manage-profile.index')->with('success', 'Profile updated successfully!');
        } else {
            return back()->with('error', 'Failed to update profile.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
