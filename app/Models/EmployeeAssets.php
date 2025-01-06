<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssets extends Model
{
    use HasFactory;

    protected $primaryKey = 'emp_id';

    protected $fillable = [
        'emp_id',
        'dept_manager',
        'hire_date',
        'official_emp_id',
        'mst_account',
        'emp_email',
        'work_status',
        'project_department',
        'working_days',
        'designation',
        'birth_cert',
        'phil_health',
        'sss',
        'tin_number',
        'pagibig_membership',
    ];

    public $incrementing = false;

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'emp_id');
    }
}
