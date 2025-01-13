<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    // Define the table associated with the model
    protected $table = 'reports';

    // Define the primary key for the table
    protected $primaryKey = 'report_id';

    // Enable mass assignment for specific fields
    protected $fillable = [
        'admin_id', 
        'emp_id',
        'emp_first_name', 
        'emp_middle_name', 
        'emp_last_name', 
        'email', 
        'official_emp_id',
        'work_type', 
        'project_department',
        'dept_manager',
        'hire_date',
        'created_at',
    ];

    /**
     * Get the admin that owns the report.
     */
    public function admin()
    {
        return $this->belongsTo(AdminInfo::class, 'admin_id', 'admin_id');
    }

    /**
     * Get the employee that owns the report.
     */
    public function employee()
    {
        return $this->belongsTo(Employees::class, 'emp_id', 'emp_id');
    }
}
