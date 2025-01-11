<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\EmployeeAssets;
use App\Models\AdminInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\JobType;

use Illuminate\Http\Request;

class AddEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $companyDepartment = Category::all();
        $workStatus = JobType::all();
        return view('admin.add-employee', compact('companyDepartment', 'workStatus'));
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
    try {
        // Validate the request data
        $validated = $request->validate([
            // Personal Information
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:employees,email',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string|in:single,married,divorced',
            'gender' => 'nullable|string|in:male,female,other',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    
            // Professional Information
            'dept_manager' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'official_emp_id' => 'required|string|max:50',
            'mst_account' => 'nullable|string|max:255',
            'work_status' => 'required|string|exists:job_types,job_type_name',
            'project_department' => 'required|string|exists:categories,category_name',
            'working_days' => 'nullable|string|max:100',
            'designation' => 'required|string|max:100',
            'emp_email' => 'required|email|unique:employee_assets,emp_email',
            // Professional Assets Information
            'birth_cert' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
            'phil_health' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
            'sss' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
            'tin_number' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
            'pagibig_membership' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        // Retrieve the authenticated user using the Auth facade
        $user = User::find(Auth::id());

        // Check if the authenticated user is an admin
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        // Retrieve the admin_info record for the logged-in admin
        $adminInfo = AdminInfo::where('user_id', $user->user_id)->first();

        if (!$adminInfo) {
            return response()->json([
                'success' => false,
                'message' => 'Admin information not found.'
            ], 404);
        }

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_img')) {
            $file = $request->file('profile_img');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension(); // Unique file name
            $profilePicturePath = $file->storeAs('employee-management/emp-2x2', $fileName, 'public');
        }

        // Document Submission Uploads
        $documentPaths = [
            'birth_cert' => 'employee-management/emp-birth-certificate',
            'phil_health' => 'employee-management/emp-philhealth',
            'sss' => 'employee-management/emp-sss',
            'tin_number' => 'employee-management/emp-tin-number',
            'pagibig_membership' => 'employee-management/emp-pag-ibig',
        ];

        $documentFiles = [];

        foreach ($documentPaths as $inputName => $path) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension(); // Unique file name
                $documentFiles[$inputName] = $file->storeAs($path, $fileName, 'public');
            } else {
                $documentFiles[$inputName] = null; // In case no file was uploaded for this document
            }
        }

        // Combine province, city, and zip code into one address
        $completeAddress = $request->province . ', ' . $request->city . ' ' . $request->zip_code;

        // Create Employee Record
        $employee = Employees::create([
            'emp_pic' => $profilePicturePath,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'marital_status' => $request->marital_status,
            'gender' => $request->gender,
            'complete_address' => $completeAddress,
            'admin_id' => $adminInfo->admin_id, // Associate the employee with the admin
        ]);

        // Create EmployeeAssets Record
        EmployeeAssets::create([
            'emp_id' => $employee->emp_id, // Manually set Foreign Key
            'dept_manager' => $request->dept_manager,
            'hire_date' => $request->hire_date,
            'official_emp_id' => $request->official_emp_id,
            'mst_account' => $request->mst_account,
            'work_status' => $request->work_status,
            'emp_email' => $request->emp_email,
            'project_department' => $request->project_department,
            'working_days' => $request->working_days,
            'designation' => $request->designation,
            'birth_cert' => $documentFiles['birth_cert'],
            'phil_health' => $documentFiles['phil_health'],
            'sss' => $documentFiles['sss'],
            'tin_number' => $documentFiles['tin_number'],
            'pagibig_membership' => $documentFiles['pagibig_membership'],
        ]);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Employee added successfully.',
            'redirect_url' => route('add-employee.index'),
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Catch validation exceptions and return the error messages
        return response()->json([
            'success' => false,
            'message' => $e->errors(),
        ], 422); // 422 Unprocessable Entity
    } catch (\Exception $e) {
        // Handle any other exceptions
        return response()->json([
            'success' => false,
            'message' => 'An error occurred. Please try again.',
        ], 500); // 500 Internal Server Error
    }
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
