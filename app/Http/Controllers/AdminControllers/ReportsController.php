<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\InterviewResults;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Retrieve all employees with their related assets
    $newHire = Employees::join('employee_assets', 'employees.emp_id', '=', 'employee_assets.emp_id')
        ->select(
            'employees.first_name',
            'employees.last_name',
            'employee_assets.emp_email',
            'employee_assets.official_emp_id',
            'employee_assets.project_department',
            'employee_assets.dept_manager',
            'employee_assets.hire_date',
            'employee_assets.work_status'
        )
        ->get();
    
    // Retrieve documents and interview results based on result_id
    $newDocument = InterviewResults::join('document_submissions', 'interview_results.result_id', '=', 'document_submissions.result_id')
        ->select(
            'interview_results.candidate_name',
            'interview_results.applied_job',
            DB::raw('`document_submissions`.`2x2_pic` as `2x2_pic`'),
            DB::raw('`document_submissions`.`birth_certificate` as `birth_certificate`'),
            DB::raw('`document_submissions`.`tin_number` as `tin_number`'),
            DB::raw('`document_submissions`.`philhealth_id` as `philhealth_id`'),
            DB::raw('`document_submissions`.`pagibig_membership_id` as `pagibig_membership_id`'),
            DB::raw('`document_submissions`.`sss` as `sss`'),
            DB::raw('`document_submissions`.`bir_form` as `bir_form`'),
            DB::raw('`document_submissions`.`health_cert` as `health_cert`')
        )
        ->get();
    
    return view('admin.reports', compact('newHire', 'newDocument'));
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
