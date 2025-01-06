<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\InterviewResults; 
use Illuminate\Support\Facades\Validator;


class ResultNotificationController extends Controller
{
    // This method retrieves all interview Results` and passes them to the view
    public function index()
    {
        // Fetch interview result data from the database
        $result = InterviewResults::all(); // Fetching all records; you might want to filter this based on your criteria

        // Pass the data to the view
        return view('admin.result-notification', compact('result'));
    }


}
