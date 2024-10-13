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
        'job_title' => 'required|string|max:500',
        'job_description' => 'required|string',
        'jobCategory' => 'required|integer',
        'jobType' => 'required|integer',
        'job_location' => 'required|string|max:500',
        'requirements' => 'required|string',
        'company_benefits' => 'nullable|string',
        'keywords' => 'nullable|string',
        'max_hires' => 'required|integer',
        'job_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'job_duration' => 'nullable|string',
        'basic_pay' => 'required|string|max:500',
    ]);

    // Strip HTML tags to avoid saving them in the database
    $jobDescription = strip_tags($request->job_description);
    $requirements = strip_tags($request->requirements);
    $companyBenefits = strip_tags($request->company_benefits);

    // Initialize $data array for common fields
    $data = [
        'job_title' => $request->job_title,
        'job_description' => $jobDescription,  // Saving without HTML tags
        'category_id' => $request->jobCategory,
        'job_type_id' => $request->jobType,
        'job_location' => $request->job_location,
        'requirements' => $requirements,  // Saving without HTML tags
        'company_benefits' => $companyBenefits,  // Saving without HTML tags
        'keywords' => $request->keywords,
        'creation_date' => now(),
        'max_hires' => $request->max_hires,
    ];

    // Handle file upload for job_photo
    if ($request->hasFile('job_photo')) {
        $file = $request->file('job_photo');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/job-postings', $fileName, 'public'); // Store the file in the directory
        
        // Save the file path in the $data array
        $data['job_photo'] = '/storage/' . $filePath;
    }

    // Determine the job type and save to the correct table
    $jobType = JobType::where('job_type_id', $request->jobType)->first();

    if ($jobType) {
        if ($jobType->job_type_name === 'Full-time') {
            // Add specific fields for Full-time job
            FullTimeJobPosting::create([
                'job_title' => $data['job_title'],
                'job_description' => $data['job_description'],
                'category_id' => $data['category_id'],
                'job_type_id' => $data['job_type_id'],
                'job_location' => $data['job_location'],
                'requirements' => $data['requirements'],
                'basic_pay' => $request->basic_pay,  // Field specific to Full-time
                'company_benefits' => $data['company_benefits'],
                'keywords' => $data['keywords'],
                'creation_date' => $data['creation_date'],
                'max_hires' => $data['max_hires'],
                'job_photo' => isset($data['job_photo']) ? $data['job_photo'] : null,  // Handle if no file is uploaded
            ]);
        } elseif ($jobType->job_type_name === 'Freelance') {
            // Add specific fields for Freelance job
            FreelanceJobPosting::create([
                'fl_job_title' => $data['job_title'],
                'fl_job_description' => $data['job_description'],
                'fl_category_id' => $data['category_id'],
                'fl_job_type_id' => $data['job_type_id'],
                'fl_job_location' => $data['job_location'],
                'fl_requirements' => $data['requirements'],
                'fl_basic_pay' => $request->basic_pay,  // Field specific to Freelance
                'fl_company_benefits' => $data['company_benefits'],
                'keywords' => $data['keywords'],
                'creation_date' => $data['creation_date'],
                'max_hires' => $data['max_hires'],
                'job_duration' => $request->job_duration,  // Freelance specific field
                'job_photo' => isset($data['job_photo']) ? $data['job_photo'] : null,  // Handle if no file is uploaded
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
