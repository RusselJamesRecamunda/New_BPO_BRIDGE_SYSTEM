<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\EmployeeAssets;
use Illuminate\Support\Facades\DB;

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
                'employee_assets.work_status',
                'employees.created_at'
            )
            ->get();
    
        // Count all employees
        $employeeCount = Employees::count();

        // Calculate new hires within the past week
        $newHiresCount = Employees::where('created_at', '>=', now()->subWeek())->count();

         // Count Freelance and Full-Time employees using EmployeeAssets model
        $workStatusCounts = EmployeeAssets::whereIn('work_status', ['Freelance', 'Full-time'])
        ->select('work_status', DB::raw('COUNT(*) as count'))
        ->groupBy('work_status')
        ->pluck('count', 'work_status');

        // Extract counts from the result
        $freelanceCount = $workStatusCounts->get('Freelance', 0);
        $fullTimeCount = $workStatusCounts->get('Full-time', 0);
        // Pass the data to the view
        return view('admin.employees', compact('employees', 'employeeCount', 'newHiresCount', 'freelanceCount', 'fullTimeCount'));
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
