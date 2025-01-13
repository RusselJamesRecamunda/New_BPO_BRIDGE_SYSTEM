<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Reports;
use App\Models\InterviewResults;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Initialize the query to retrieve all employees from the Reports model
        $newHireQuery = Reports::select(
            'emp_first_name',
            'emp_middle_name',
            'emp_last_name',
            'email',
            'official_emp_id',
            'work_type',
            'project_department',
            'dept_manager',
            'hire_date',
            'created_at'
        );
    
        // Filter by week if 'week' parameter is provided
        if ($request->has('week')) {
            $newHireQuery->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);
        }
    
        // Filter by month if 'month' parameter is provided
        if ($request->has('month')) {
            $newHireQuery->whereMonth('created_at', $request->input('month'));
        }
    
        // Retrieve the filtered data
        $newHire = $newHireQuery->get();
    
        // Retrieve documents and interview results based on result_id
        $newDocument = InterviewResults::join('document_submissions', 'interview_results.result_id', '=', 'document_submissions.result_id')
            ->select(
                'interview_results.candidate_name',
                'interview_results.applied_job',
                'document_submissions.doc_id',  // Include doc_id here
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
        
        // Return the view with the filtered data
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
