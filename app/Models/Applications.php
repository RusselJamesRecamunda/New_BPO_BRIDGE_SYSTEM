<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id';

    protected $fillable = [
        'app_date',
        'applicant_name',
        'applicant_email',
        'applicant_phone',
        'applicant_location',
        'job_type',
        'job_category',
        'resume_cv',
        'cover_letter',
        'max_hires',
        'applicant_emp_status',
        'application_status',
        'list_status',
        'user_id',
        'full_job_ID',
        'fl_jobID'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Full-time Job Postings
    public function fullTimeJobPosting()
    {
        return $this->belongsTo(FullTimeJobPosting::class, 'full_job_ID', 'full_job_ID');
    }

    // Relationship with Freelance Job Postings
    public function freelanceJobPosting()
    {
        return $this->belongsTo(FreelanceJobPosting::class, 'fl_jobID', 'fl_jobID');
    }

    // Relationship with Job Candidates
    public function jobCandidate()
    {
        return $this->belongsTo(JobCandidates::class, 'application_id', 'application_id');
    }
}
