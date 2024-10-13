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
        'job_type',
        'job_category',
        'resume_cv',
        'cover_letter',
        'max_hires',
        'application_status',
        'user_id',
        'full_jobID',
        'fl_jobID'
    ];

    // Relationship with Interview Results
    public function interviewResults()
    {
        return $this->hasMany(InterviewResults::class, 'application_id');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Full-time Job Postings
    public function fullTimeJobPosting()
    {
        return $this->belongsTo(FullTimeJobPosting::class, 'full_jobID');
    }

    // Relationship with Freelance Job Postings
    public function freelanceJobPosting()
    {
        return $this->belongsTo(FreelanceJobPosting::class, 'fl_jobID');
    }
}
