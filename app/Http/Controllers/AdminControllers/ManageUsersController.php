<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManageUsersController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 14); // Default to 14 if not specified

        // Retrieve saved columns or default to available columns
        $savedColumns = session('selected_columns', []); // Start with empty array

        // Define the actual database column names
        $databaseColumns = [
            'user_id', // Corresponds to User ID
            'first_name', // Corresponds to User Name
            'email', // Corresponds to Email
            'role', // Corresponds to User Role
            'email_verified_at', // Corresponds to Date Verified
            'activity_status', // Corresponds to Activity Status
            'user_status', // Corresponds to User Status
            'created_at', // Corresponds to Created At
            'updated_at', // Corresponds to Updated At
        ];

        // Check if it's a request to get columns
        if ($request->has('action') && $request->input('action') === 'get_columns') {
            return response()->json([
                'availableColumns' => $databaseColumns,
                'savedColumns' => $savedColumns,
            ]);
        }

        // Check if it's a request to save columns
        if ($request->has('action') && $request->input('action') === 'save_columns') {
            session(['selected_columns' => $request->input('columns', [])]); // Save the selected columns in the session
            return response()->json(['success' => true]);
        }

        // Use saved columns for querying if they exist
        $selectedColumns = $savedColumns ?: $databaseColumns;

        try {
            $users = User::select($selectedColumns)
                ->when($search, function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('user_id', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('role', 'like', "%{$search}%")
                            ->orWhere('email_verified_at', 'like', "%{$search}%")
                            ->orWhere('activity_status', 'like', "%{$search}%")
                            ->orWhere('user_status', 'like', "%{$search}%");
                    });
                })
                ->paginate($perPage);

            if ($request->ajax()) {
                if ($users->isEmpty()) {
                    return response()->json(['html' => '', 'message' => 'No results found.']);
                }

                return response()->json(['html' => view('admin.users', compact('users'))->render()]);
            }

            return view('admin.users', compact('users', 'search'));
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching users: ' . $e->getMessage()], 500);
        }
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
