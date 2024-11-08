<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssets extends Model
{
    use HasFactory;

    protected $primaryKey = 'emp_id';
    public $incrementing = false;

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'emp_id');
    }
}
