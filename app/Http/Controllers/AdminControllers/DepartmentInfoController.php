<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Employees;

use Illuminate\Http\Request;

class DepartmentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if the request has a specific department filter
        if ($request->has('department')) {
            $department = $request->input('department');
    
            // Retrieve employees for the specific department
            $employees = Employees::join('employee_assets', 'employees.emp_id', '=', 'employee_assets.emp_id')
                ->select(
                    'employees.first_name',
                    'employees.last_name',
                    'employees.email',
                    'employees.emp_pic', // Ensure this is in the employees table
                    'employee_assets.official_emp_id',
                    'employee_assets.project_department',
                    'employee_assets.work_status',
                    'employee_assets.designation'
                )
                ->where('employee_assets.project_department', $department)
                ->get();
    
            // Return the department-specific view
            return view('admin.department-info', compact('department', 'employees'));
        }
    
        // Retrieve all employees grouped by department for the main list
        $employeeDept = Employees::join('employee_assets', 'employees.emp_id', '=', 'employee_assets.emp_id')
            ->select(
                'employees.first_name',
                'employees.last_name',
                'employees.email',
                'employees.emp_pic', // Ensure this is in the employees table
                'employee_assets.official_emp_id',
                'employee_assets.project_department',
                'employee_assets.work_status',
                'employee_assets.designation'
            )
            ->get();
    
        $departments = $employeeDept->groupBy('project_department');
    
        // Return the main departments view
        return view('admin.departments', compact('departments'));
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
