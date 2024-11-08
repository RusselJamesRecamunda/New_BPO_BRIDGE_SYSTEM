<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\FreelanceJobPosting;
use App\Models\FullTimeJobPosting;
use App\Models\Category;
use App\Models\JobType; 
use Illuminate\Http\Request;


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
        $freelanceJobs = FreelanceJobPosting::orderBy('creation_date', 'desc')->take(2)->get();
        $fullTimeJobs = FullTimeJobPosting::orderBy('creation_date', 'desc')->take(2)->get(); // Order by creation_date

        return view('home', compact('freelanceJobs', 'fullTimeJobs', 'categories', 'jobTypes'));
    } else {
        // Data specific to the admin jobs view
        $freelanceJobs = FreelanceJobPosting::all();
        $fullTimeJobs = FullTimeJobPosting::all();

        return view('admin.jobs', compact('freelanceJobs', 'fullTimeJobs', 'categories', 'jobTypes'));
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
