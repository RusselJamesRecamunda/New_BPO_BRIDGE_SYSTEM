<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model 
{
    use HasFactory;

    protected $table = 'contracts';

    protected $primaryKey = 'contract_id';

    protected $fillable = [
        'application_id',
        'emp_id',
        'job_type_name',
        'contract_file',
        'start_date',
        'end_date',
        'contract_status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'emp_id');
    }

    public function application()
    {
        return $this->belongsTo(Applications::class, 'application_id');
    }
}

