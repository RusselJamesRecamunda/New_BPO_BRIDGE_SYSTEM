<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'emp_id'; // Custom primary key

    protected $fillable = [
        'official_emp_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'gender',
        'marital_status',
        'phone_no',
        'address',
        'date_of_birth',
        'role',
        'project_department',
        'manager',
        'admin_id'
    ];

    // Each employee belongs to one admin
    public function admin()
    {
        return $this->belongsTo(AdminInfo::class, 'admin_id', 'admin_id');
    }

    // Define the one-to-many relationship with the reports
    public function reports()
    {
        return $this->hasMany(Reports::class, 'emp_id', 'emp_id');
    }
}
