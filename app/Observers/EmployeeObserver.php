<?php

namespace App\Observers;

use App\Models\Employees;
use App\Models\EmployeeAssets;
use App\Models\Reports;
use Illuminate\Support\Facades\Log;

class EmployeeObserver
{
    /**
     * Handle the Employees "created" event.
     */
    public function created(Employees $employee): void
    {
        $this->syncReport($employee);
    }

    /**
     * Handle the Employees "updated" event.
     */
    public function updated(Employees $employee): void
    {
        $this->syncReport($employee);
    }

    /**
     * Synchronize Employee and EmployeeAssets data with Reports.
     */
    private function syncReport(Employees $employee): void
    {
        Log::info('Syncing Report for Employee:', ['emp_id' => $employee->emp_id]);
    
        // Fetch the related EmployeeAssets record
        $assets = EmployeeAssets::where('emp_id', trim($employee->emp_id))->first();
    
        if (!$assets) {
            Log::error('No EmployeeAssets found for emp_id: ' . $employee->emp_id);
            return; // Exit if no assets found
        }
    
        Log::info('EmployeeAssets Data:', $assets->toArray());
    
        // Prepare the data to insert or update in the Reports table
        $reportData = [
            'admin_id'          => $employee->admin_id,
            'emp_id'            => $employee->emp_id,
            'emp_first_name'    => $employee->first_name,
            'emp_middle_name'   => $employee->middle_name,
            'emp_last_name'     => $employee->last_name,
            'email'             => $employee->email,
            'official_emp_id'   => $assets->official_emp_id,
            'project_department'=> $assets->project_department,
            'dept_manager'      => $assets->dept_manager,
            'hire_date'         => $assets->hire_date,
        ];
    
        Log::info('Prepared Report Data:', $reportData);
    
        // Update or create the Reports record
        $report = Reports::updateOrCreate(
            ['emp_id' => $employee->emp_id], // Match on emp_id
            $reportData
        );
    
        Log::info('Report Updated or Created:', $report->toArray());
    }
    

    /**
     * Handle the Employees "deleted" event.
     */
    public function deleted(Employees $employees): void
    {
        //
    }

    /**
     * Handle the Employees "restored" event.
     */
    public function restored(Employees $employees): void
    {
        //
    }

    /**
     * Handle the Employees "force deleted" event.
     */
    public function forceDeleted(Employees $employees): void
    {
        //
    }
}
