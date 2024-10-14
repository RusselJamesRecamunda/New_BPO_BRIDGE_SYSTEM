<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Interviews;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InterviewsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch and return data for FullCalendar when called via AJAX
            $interviews = Interviews::all(['interview_id', 'candidate_name', 'applied_job', 'interview_mode', 'email', 'phone', 'interview_date', 'interview_time']);
            
            $events = $interviews->map(function ($interview) {
                return [
                    'id' => $interview->interview_id,
                    'title' => $interview->candidate_name,
                    'start' => $interview->interview_date . 'T' . $interview->interview_time,
                    'applied_job' => $interview->applied_job,
                    'interview_mode' => $interview->interview_mode,
                    'email' => $interview->email,
                    'phone' => $interview->phone,
                ];
            });
    
            return response()->json($events); // Return JSON response for FullCalendar
        }
    
        // Render the interviews view when not an AJAX request
        return view('admin.interviews');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        //
    }

    
    // Store a new interview
//     public function store(Request $request)
// {
//     $request->validate([
//         'candidate_name' => 'required|string|max:255',
//         'applied_job' => 'required|string|max:255',
//         'interview_mode' => 'required|string|max:255',
//         'email' => 'required|email|max:255',
//         'phone' => 'required|string|max:15',
//         'interview_date' => 'required|date',
//         'interview_time' => 'required|string|max:5',
//         'admin_id' => 'required|exists:admins,id', // Ensure admin_id is validated
//     ]);

//     $interview = new Interviews([
//         'candidate_name' => $request->candidate_name,
//         'applied_job' => $request->applied_job,
//         'interview_mode' => $request->interview_mode,
//         'email' => $request->email,
//         'phone' => $request->phone,
//         'interview_date' => $request->interview_date,
//         'interview_time' => $request->interview_time,
//         'admin_id' => $request->admin_id, // Add this line
//     ]);

//     $interview->save();

//     return redirect()->route('interviews.index')->with('success', 'Interview scheduled successfully.');
// }
public function store(Request $request)
{
    // Validate your request data
    $validatedData = $request->validate([
        'candidate_name' => 'required|string|max:255',
        'applied_job' => 'required|string|max:255',
        'interview_mode' => 'required|string|max:50',
        'email' => 'required|email',
        'phone' => 'required|string|max:15',
        'interview_date' => 'required|date',
        'interview_time' => 'required|string|max:5', // Adjust as necessary
    ]);

    // Create a new interview without admin_id
    $interview = new Interviews($validatedData);
    $interview->save();

    return response()->json(['message' => 'Interview scheduled successfully!']);
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

      // Update an existing interview
      public function update(Request $request, $id)
{
    $request->validate([
        'candidate_name' => 'required|string|max:255',
        'applied_job' => 'required|string|max:255',
        'interview_mode' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'interview_date' => 'required|date',
        'interview_time' => 'required|date_format:H:i',
    ]);

    $interview = Interviews::findOrFail($id);
    $interview->candidate_name = $request->candidate_name;
    $interview->applied_job = $request->applied_job;
    $interview->interview_mode = $request->interview_mode;
    $interview->email = $request->email;
    $interview->phone = $request->phone;
    $interview->interview_date = $request->interview_date;
    $interview->interview_time = $request->interview_time;
    $interview->save();

    // Return updated event data to the frontend
    return response()->json([
        'success' => true,
        'message' => 'Interview updated successfully.',
        'event' => [
            'id' => $interview->interview_id,
            'title' => $interview->candidate_name,
            'start' => $interview->interview_date . 'T' . $interview->interview_time,
            'applied_job' => $interview->applied_job,
            'interview_mode' => $interview->interview_mode,
            'email' => $interview->email,
            'phone' => $interview->phone,
        ]
    ]);
}


    // Delete an interview
    public function destroy($id)
    {
        $interview = Interviews::findOrFail($id);
        $interview->delete();

        return response()->json(['success' => true, 'message' => 'Interview deleted successfully.']);
    }
}
