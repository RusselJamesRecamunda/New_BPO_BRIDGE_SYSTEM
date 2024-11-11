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
