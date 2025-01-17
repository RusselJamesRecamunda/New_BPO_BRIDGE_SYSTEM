<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interviews;
use App\Models\Applications;
use App\Models\Employees;
use App\Models\User;

class AdminController extends Controller
{ 
    public function index()
{
    // Get counts for each status by week (assuming `created_at` is used for week grouping)
    $weeks = [1, 2, 3, 4]; // Week 1, Week 2, Week 3, Week 4

    $pendingApplications = [];
    $scheduledInterviews = [];
    $rejectedApplications = [];

    foreach ($weeks as $week) {
        $pendingApplications[] = Applications::where('application_status', 'Pending')
            ->whereBetween('created_at', [$this->getStartOfWeek($week), $this->getEndOfWeek($week)])
            ->count();

        $scheduledInterviews[] = Interviews::whereBetween('created_at', [$this->getStartOfWeek($week), $this->getEndOfWeek($week)])
            ->count();

        $rejectedApplications[] = Applications::where('application_status', 'Rejected')
            ->whereBetween('created_at', [$this->getStartOfWeek($week), $this->getEndOfWeek($week)])
            ->count();
    }

    // Ensure that we always have 4 weeks of data (with 0 if no data for that week)
    $pendingApplications = $this->fillEmptyWeeks($pendingApplications);
    $scheduledInterviews = $this->fillEmptyWeeks($scheduledInterviews);
    $rejectedApplications = $this->fillEmptyWeeks($rejectedApplications);

    // Get the total counts for the other stats
    $scheduledInterviewsCount = Interviews::count();
    $ApplicationsCount = Applications::count();
    $EmployeesCount = Employees::count();
    $UsersCount = User::count();

    return view('admin.dashboard', compact(
        'scheduledInterviewsCount', 
        'UsersCount', 
        'ApplicationsCount', 
        'EmployeesCount', 
        'pendingApplications', 
        'scheduledInterviews', 
        'rejectedApplications'
    ));
}

    
    private function getStartOfWeek($week)
    {
        // Assuming you want to calculate the start of the week (e.g., Sunday)
        return now()->startOfYear()->addWeeks($week - 1)->startOfWeek();
    }
    
    private function getEndOfWeek($week)
    {
        // Assuming you want to calculate the end of the week (e.g., Saturday)
        return now()->startOfYear()->addWeeks($week - 1)->endOfWeek();
    }
    
    // Helper function to ensure empty weeks are filled with 0 if no data is found
    private function fillEmptyWeeks($data)
    {
        // If any week has no data, we ensure it is set to 0
        return array_pad($data, 4, 0); // Make sure we always have 4 weeks of data, padding with 0s
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
