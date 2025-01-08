<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\FullTimeJobPosting;
use App\Models\FreelanceJobPosting;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // Store HTML content directly without stripping tags
    $jobDescription = $request->job_description;
    $requirements = $request->requirements;
    $companyBenefits = $request->company_benefits;

    // Initialize $data array for common fields
    $data = [
        'job_title' => $request->job_title,
        'job_description' => $jobDescription,
        'category_id' => $request->jobCategory,
        'job_type_id' => $request->jobType,
        'job_location' => $request->job_location,
        'requirements' => $requirements,
        'company_benefits' => $companyBenefits,
        'keywords' => $request->keywords,
        'creation_date' => now(),
        'max_hires' => $request->max_hires,
    ];

    // Handle file upload for job_photo
    if ($request->hasFile('job_photo')) {
        $file = $request->file('job_photo');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $uploadPath = public_path('uploads/job-postings');
        $file->move($uploadPath, $fileName);

        $data['job_photo'] = 'uploads/job-postings/' . $fileName;
    }

    // Get the logged-in user ID
    $userId = Auth::id();
    
    // Determine the job type and save to the correct table
    $jobType = JobType::where('job_type_id', $request->jobType)->first();

    if ($jobType) {
        if ($jobType->job_type_name === 'Full-time') {
            // Add specific fields for Full-time job and assign user_id
            FullTimeJobPosting::create([
                'job_title' => $data['job_title'],
                'job_description' => $data['job_description'],
                'category_id' => $data['category_id'],
                'job_type_id' => $data['job_type_id'],
                'user_id' => $userId,
                'job_location' => $data['job_location'],
                'requirements' => $data['requirements'],
                'basic_pay' => $request->basic_pay,
                'company_benefits' => $data['company_benefits'],
                'keywords' => $data['keywords'],
                'creation_date' => $data['creation_date'],
                'max_hires' => $data['max_hires'],
                'job_photo' => $data['job_photo'] ?? null,
                'job_status' => 'Open',
            ]);
        } elseif ($jobType->job_type_name === 'Freelance') {
            // Add specific fields for Freelance job and assign fl_user_id
            FreelanceJobPosting::create([
                'fl_job_title' => $data['job_title'],
                'fl_job_description' => $data['job_description'],
                'fl_category_id' => $data['category_id'],
                'fl_job_type_id' => $data['job_type_id'],
                'fl_user_id' => $userId,
                'fl_job_location' => $data['job_location'],
                'fl_requirements' => $data['requirements'],
                'fl_basic_pay' => $request->basic_pay,
                'fl_company_benefits' => $data['company_benefits'],
                'keywords' => $data['keywords'],
                'creation_date' => $data['creation_date'],
                'max_hires' => $data['max_hires'],
                'job_duration' => $request->job_duration,
                'job_photo' => $data['job_photo'] ?? null,
                'job_status' => 'Open',
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
    public function edit($id)
    {
        // Check if the job posting is full-time or freelance by checking the existence of the job in the respective tables
        $fullTimeJob = FullTimeJobPosting::with('category', 'jobType')->where('full_job_ID', $id)->first();
        $freelanceJob = FreelanceJobPosting::with('category', 'jobType')->where('fl_jobID', $id)->first();
    
        // Determine the job type and data
        if ($fullTimeJob) {
            $job = $fullTimeJob;
            $jobType = 'full-time';
        } elseif ($freelanceJob) {
            $job = $freelanceJob;
            $jobType = 'freelance';
        } else {
            abort(404, 'Job not found');
        }
    
        // Fetch categories and job types for the dropdowns
        $categories = Category::all();
        $jobTypes = JobType::all();
    
        return view('admin.edit-job-posting', compact('job', 'categories', 'jobTypes', 'jobType'));
    }    
    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input
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
            // 'job_duration' => 'nullable|string',
            'basic_pay' => 'nullable|string|max:500',
        ]);
    
        // Check if the job posting is full-time or freelance
        $job = FullTimeJobPosting::where('full_job_ID', $id)->first() ??
               FreelanceJobPosting::where('fl_jobID', $id)->first();
    
        if (!$job) {
            abort(404, 'Job not found');
        }
    
        // Update the common fields
        $job->job_title = $request->job_title;
        $job->job_description = $request->job_description;
        $job->category_id = $request->jobCategory;
        $job->job_type_id = $request->jobType;
        $job->job_location = $request->job_location;
        $job->requirements = $request->requirements;
        $job->company_benefits = $request->company_benefits;
        $job->keywords = $request->keywords;
        $job->max_hires = $request->max_hires;
        // $job->job_photo = $request->job_photo;
    
        // Handle file upload for job_photo
        if ($request->hasFile('job_photo')) {
            $file = $request->file('job_photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $uploadPath = public_path('uploads/job-postings');

            // Move the uploaded file to the desired location
            $file->move($uploadPath, $fileName);

            // Delete the old photo if it exists
            if (!empty($job->job_photo) && file_exists(public_path($job->job_photo))) {
                unlink(public_path($job->job_photo));
            }

            // Save the new file path
            $job->job_photo = 'uploads/job-postings/' . $fileName;
        }

    
        // Handle job-specific fields
        if ($job instanceof FullTimeJobPosting) {
            $job->basic_pay = $request->basic_pay;
        }
    
        $job->save();
    
        return redirect()->route('job-posting.edit', ['id' => $job->full_job_ID ?? $job->fl_jobID])
            ->with('success', 'Job updated successfully');
    }
    



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
