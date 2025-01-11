<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\FreelanceJobPosting;
use App\Models\FullTimeJobPosting;
use App\Models\Category;
use App\Models\JobType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index($forHome = false)
    {
        // Retrieve all categories and job types
        $categories = Category::all()->keyBy('category_id');
        $jobTypes = JobType::all();

        if ($forHome) {
            // Data specific to the home view
            $freelanceJobs = FreelanceJobPosting::orderBy('creation_date', 'desc')->take(5)->get();
            $fullTimeJobs = FullTimeJobPosting::orderBy('creation_date', 'desc')->take(5)->get(); // Order by creation_date
            $freelanceLocations = DB::table('freelance_job_postings')->pluck('fl_job_location');
            $fullTimeLocations = DB::table('full_time_job_postings')->pluck('job_location');
            $locations = $freelanceLocations->merge($fullTimeLocations)->unique();

            return view('home', compact('freelanceJobs', 'fullTimeJobs', 'categories', 'jobTypes', 'locations'));
        } else {
            // Data specific to the admin jobs view
            $freelanceJobs = FreelanceJobPosting::all();
            $fullTimeJobs = FullTimeJobPosting::all();
            $freelanceLocations = DB::table('freelance_job_postings')->pluck('fl_job_location');
            $fullTimeLocations = DB::table('full_time_job_postings')->pluck('job_location');
            $locations = $freelanceLocations->merge($fullTimeLocations)->unique();

            return view('admin.jobs', compact('freelanceJobs', 'fullTimeJobs', 'categories', 'jobTypes', 'locations'));
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
    public function search(Request $request)
{
    // dd($request->all()); 
    // Get search parameters from the request
    $keywords = $request->input('keywords');
    $category = $request->input('category'); // This is the selected category_id
    $location = $request->input('location');
    $type = $request->input('type'); // The selected job_type_id
    $salary = $request->input('salary');
    $time = $request->input('time');
    
    // Initialize queries for both tables
    $fullTimeQuery = DB::table('full_time_job_postings');
    $freelanceQuery = DB::table('freelance_job_postings');
    
    // Apply filters to both queries
    if ($keywords) {
        $fullTimeQuery->where(function ($q) use ($keywords) {
            $q->where('job_title', 'like', "%$keywords%")
                ->orWhere('job_description', 'like', "%$keywords%");
        });

        $freelanceQuery->where(function ($q) use ($keywords) {
            $q->where('fl_job_title', 'like', "%$keywords%")
                ->orWhere('fl_job_description', 'like', "%$keywords%");
        });
    }

    if ($category) {
        // Apply category filter for both full-time and freelance job postings
        $fullTimeQuery->where('category_id', $category); // Ensure category_id matches
        $freelanceQuery->where('fl_category_id', $category); // Ensure fl_category_id matches
    }

    if ($location) {
        $coreLocation = $this->extractCoreLocation($location);

        $fullTimeQuery->where(function ($q) use ($coreLocation) {
            $q->orWhere('job_location', 'like', "%$coreLocation%");
        });

        $freelanceQuery->where(function ($q) use ($coreLocation) {
            $q->orWhere('fl_job_location', 'like', "%$coreLocation%");
        });
    }

    if ($salary) {
        $salaryRange = str_replace(['₱', ',', ' '], '', $salary);
        [$inputMin, $inputMax] = explode('-', $salaryRange);

        $fullTimeQuery->where(function ($q) use ($inputMin, $inputMax) {
            $q->whereRaw("CAST(REPLACE(SUBSTRING_INDEX(basic_pay, '–', 1), '₱', '') AS UNSIGNED) >= ?", [$inputMin])
              ->whereRaw("CAST(REPLACE(SUBSTRING_INDEX(basic_pay, '–', -1), '₱', '') AS UNSIGNED) <= ?", [$inputMax]);
        });

        $freelanceQuery->where(function ($q) use ($inputMin, $inputMax) {
            $q->whereRaw("CAST(REPLACE(SUBSTRING_INDEX(fl_basic_pay, '–', 1), '₱', '') AS UNSIGNED) >= ?", [$inputMin])
              ->whereRaw("CAST(REPLACE(SUBSTRING_INDEX(fl_basic_pay, '–', -1), '₱', '') AS UNSIGNED) <= ?", [$inputMax]);
        });
    }

    if ($time) {
        $timeMap = [
            '24' => Carbon::now()->subHours(24),
            '168' => Carbon::now()->subDays(7),
            '720' => Carbon::now()->subDays(30),
        ];
        $timeThreshold = $timeMap[$time] ?? null;

        if ($timeThreshold) {
            $fullTimeQuery->where('creation_date', '>=', $timeThreshold);
            $freelanceQuery->where('creation_date', '>=', $timeThreshold);
        }
    }

    if ($type) {
        // Apply job type filter for both full-time and freelance job postings
        $fullTimeQuery->where('job_type_id', $type); // Match job_type_id for full-time jobs
        $freelanceQuery->where('fl_job_type_id', $type); // Match fl_job_type_id for freelance jobs
    }

    if ($type === 'full_time') {
        $fullTimeJobs = $fullTimeQuery->get();
        $freelanceJobs = collect(); // Empty collection
    } elseif ($type === 'freelance') {
        $freelanceJobs = $freelanceQuery->get();
        $fullTimeJobs = collect(); // Empty collection
    } else {
        $fullTimeJobs = $fullTimeQuery->get();
        $freelanceJobs = $freelanceQuery->get();
    }

    // Fetch categories for the dropdown
    $categories = DB::table('categories')->get();
    $jobTypes = DB::table('job_types')->get(); // Fetch job types for the dropdown

    return view('home', [
        'fullTimeJobs' => $fullTimeJobs,
        'freelanceJobs' => $freelanceJobs,
        'categories' => $categories,
        'jobTypes' => $jobTypes, // Pass job types to the view
        'keywords' => $keywords,
        'selectedCategory' => $category,
        'selectedLocation' => $location,
        'selectedType' => $type,
        'selectedSalary' => $salary,
        'selectedTime' => $time,
    ]);
}
    
    // Helper function to extract the core location (before any commas or extensions)
    private function extractCoreLocation($location)
    {
        // Remove everything after the first comma, if any
        $locationParts = explode(',', $location);
        
        // Return the first part as the core location
        return trim($locationParts[0]);
    }
}
