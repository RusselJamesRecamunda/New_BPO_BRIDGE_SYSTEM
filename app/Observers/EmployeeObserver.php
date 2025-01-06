<?php

namespace App\Observers;

use App\Models\Employees;
use App\Models\EmployeeAssets;
use App\Models\Reports;

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
        // Fetch the related EmployeeAssets record
        $assets = EmployeeAssets::where('emp_id', $employee->emp_id)->first();

        // Prepare the data to insert or update in the Reports table
        $reportData = [
            'emp_id'            => $employee->emp_id,
            'emp_first_name'    => $employee->first_name,
            'emp_middle_name'   => $employee->middle_name,
            'emp_last_name'     => $employee->last_name,
            'email'             => $employee->email,
            'official_emp_id'   => $assets->official_emp_id ?? null,
            'project_department'=> $assets->project_department ?? null,
            'dept_manager'      => $assets->dept_manager ?? null,
            'hire_date'         => $assets->hire_date ?? null,
        ];

        // Create or update the Reports record
        Reports::updateOrCreate(
            ['emp_id' => $employee->emp_id], // Match on emp_id
            $reportData
        );
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
