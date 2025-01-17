<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Applications;
use App\Models\Interviews;
use Illuminate\Http\Request;

class ApplicantTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Group applications by job category and calculate total and percentage, limit to 5
        $applications = Applications::select('job_category', 'application_status')
            ->latest() // Ensure the latest entries are prioritized
            ->get()
            ->groupBy('job_category')
            ->map(function ($group) {
                $total = $group->count();
                $pending = $group->where('application_status', 'Pending')->count();
                $percentage = $total > 0 ? ($pending / $total) * 100 : 0;
    
                return [
                    'total' => $total,
                    'percentage' => round($percentage, 2),
                ];
            })
            ->take(5); // Limit the results to 5 categories
    
        // Calculate weekly applications data for the chart
        $weeklyData = Applications::selectRaw('WEEK(created_at) as week, COUNT(*) as total')
            ->whereMonth('created_at', now()->month)
            ->groupBy('week')
            ->orderBy('week')
            ->pluck('total', 'week');
    
        // Format data for Chart.js
        $weeks = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        $chartData = array_fill(0, 4, 0);
        foreach ($weeklyData as $week => $total) {
            // Convert collection to array before using array_keys
            $index = $week - min(array_keys($weeklyData->toArray()));
            if (isset($chartData[$index])) {
                $chartData[$index] = $total;
            }
        }
    
        // Get upcoming interviews
        $interviews = Interviews::where('interview_date', '>=', now())
            ->orderBy('interview_date')
            ->orderBy('interview_time')
            ->take(5) // Limit to 5 upcoming interviews
            ->get();
    
        return view('admin.applicant-tracker', compact('applications', 'chartData', 'weeks', 'interviews'));
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
