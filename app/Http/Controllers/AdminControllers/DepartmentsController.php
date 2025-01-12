<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\EmployeeAssets;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all employees by department with their related assets
        $employeeDept = Employees::join('employee_assets', 'employees.emp_id', '=', 'employee_assets.emp_id')
            ->select(
                'employees.emp_pic', 
                'employees.first_name',
                'employees.last_name',
                'employee_assets.project_department',
                'employee_assets.work_status',
                'employee_assets.designation',
                'employees.created_at'
            )
            ->orderBy('employees.created_at', 'desc') // Order by created_at descending
            ->get();

        // Group employees by department
        $departments = $employeeDept->groupBy('project_department');

        // Pass the grouped data to the view
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
