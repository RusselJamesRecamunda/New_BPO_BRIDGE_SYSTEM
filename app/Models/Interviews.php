<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interviews extends Model
{
    use HasFactory;

    protected $primaryKey = 'interview_id';

    protected $fillable = [
        'admin_id',
        'candidate_id',
        'candidate_name',
        'applied_job',
        'interview_mode',
        'email',
        'phone',
        'interview_date',
        'interview_time',
        'virtual_meet_link',
        'onsite_phone',
    ];

    // Relationship with Admin Information (admin)
    public function admin()
    {
        return $this->belongsTo(AdminInfo::class, 'admin_id');
    } 

    // Relationship with Interview Results
    public function interviewResults()
    {
        return $this->hasOne(InterviewResults::class, 'interview_id');
    }

    // Relationship with Job Candidates
    public function jobCandidate()
    {
        return $this->belongsTo(JobCandidates::class, 'candidate_id', 'candidate_id');
    }
}
