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
        'admin_id',
        'emp_pic',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'marital_status',
        'gender',
        'complete_address',
        'created_at',
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

     // Define the one-to-one relationship with the contracts
    public function contracts()
    {
        return $this->hasOne(Contract::class, 'emp_id');
    }

    // Define the one-to-many relationship with the Employee Assets
    public function assets()
    {
        return $this->hasOne(EmployeeAssets::class, 'emp_id');
    }
}
