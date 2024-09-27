<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\FullTimeJobPosting;
use App\Models\FreelanceJobPosting;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $jobTypes = JobType::all();
        return view('admin.job-posting', compact('categories', 'jobTypes')); // Pass categories and job types to the view
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
        // Validate the incoming data
        $request->validate([
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'jobCategory' => 'required|integer',
            'jobType' => 'required|integer',
            'job_location' => 'required|string|max:255',
            'requirements' => 'required|string',
            'company_benefits' => 'nullable|string',
            'keywords' => 'nullable|string',
            'max_hires' => 'required|integer',
            'job_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'job_duration' => 'nullable|string',
            'basic_pay' => 'nullable|numeric',
        ]);
    
        // Handle file upload if any
        $filename = null;
        if ($request->hasFile('job_photo')) {
            $file = $request->file('job_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // Store the file in the desired directory
            $file->storeAs('public/uploads/job-postings', $filename);
            
            // Set the file path to save in the database
            $filename = 'storage/uploads/job-postings/' . $filename;
        }
    
        // Determine the job type using the JobType model
        $jobType = JobType::where('job_type_id', $request->jobType)->first(); // Use job_type_id instead of id
    
        if ($jobType) {
            // Exclude user_id and fl_user_id for both types of job postings
            if ($jobType->job_type_name === 'Full-time') {
                FullTimeJobPosting::create([
                    'job_title' => $request->job_title,
                    'job_description' => $request->job_description,
                    'category_id' => $request->jobCategory,
                    'job_type_id' => $request->jobType,
                    'job_location' => $request->job_location,
                    'requirements' => $request->requirements,
                    'company_benefits' => $request->company_benefits,
                    'keywords' => $request->keywords,
                    'creation_date' => now(),
                    'max_hires' => $request->max_hires,
                    'job_photo' => $filename, // Save the file path
                ]);
            } elseif ($jobType->job_type_name === 'Freelance') {
                FreelanceJobPosting::create([
                    'fl_job_title' => $request->job_title,
                    'fl_job_description' => $request->job_description,
                    'fl_category_id' => $request->jobCategory,
                    'fl_job_type_id' => $request->jobType,
                    'fl_job_location' => $request->job_location,
                    'fl_requirements' => $request->requirements,
                    'fl_basic_pay' => $request->basic_pay,
                    'fl_company_benefits' => $request->company_benefits,
                    'keywords' => $request->keywords,
                    'creation_date' => now(),
                    'max_hires' => $request->max_hires,
                    'job_duration' => $request->job_duration,
                    'job_photo' => $filename, // Save the file path
                ]);
            }
        }
    
        return redirect()->route('job-posting.index')->with('success', 'Job posted successfully!');
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
