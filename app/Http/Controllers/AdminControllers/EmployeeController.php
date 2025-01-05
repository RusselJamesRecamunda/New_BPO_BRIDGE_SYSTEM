<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\EmployeeAssets;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all employees with their related assets
        $employees = Employees::join('employee_assets', 'employees.emp_id', '=', 'employee_assets.emp_id')
            ->select(
                'employees.emp_pic', 
                'employees.first_name',
                'employees.last_name',
                'employees.phone',
                'employee_assets.official_emp_id',
                'employee_assets.project_department',
                'employee_assets.hire_date',
                'employee_assets.work_status'
            )
            ->get();

        // Pass the data to the view
        return view('admin.employees', compact('employees'));
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
