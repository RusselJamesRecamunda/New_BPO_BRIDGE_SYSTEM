<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller; // Make sure to import the base Controller
use Illuminate\Http\Request;
use App\Models\Interviews; // Ensure the model is imported
use Illuminate\Support\Facades\Validator;


class ScheduleNotificationController extends Controller
{
    // This method retrieves all interviews and passes them to the view
    public function index()
    {
        // Fetch interview data from the database
        $interviews = Interviews::all(); // Fetching all records; you might want to filter this based on your criteria

        // Pass the data to the view
        return view('admin.schedule-notification', compact('interviews'));
    }

    // Optionally, you can add other methods here if needed
}
