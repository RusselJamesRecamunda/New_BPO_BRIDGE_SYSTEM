<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJobs extends Model
{
    use HasFactory;

    protected $table = 'saved_jobs';
    protected $primaryKey = 'save_ID';

    protected $fillable = [
        'user_id',
        'full_job_id',
        'fl_job_id',
        'job_type_name',
    ];

    // Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Define relationship to FullTimeJobPosting
    public function fullTimeJob()
    {
        return $this->belongsTo(FullTimeJobPosting::class, 'full_job_id', 'full_job_ID');
    }

    // Define relationship to FreelanceJobPosting
    public function freelanceJob()
    {
        return $this->belongsTo(FreelanceJobPosting::class, 'fl_job_id', 'fl_jobID');
    }
}
