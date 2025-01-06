<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewResults extends Model
{
    use HasFactory;
    protected $primaryKey = 'result_id';

    protected $fillable = [
        'interview_id',
        'candidate_id',
        'applied_job',
        'candidate_name',
        'interviewer',
        'interview_mode',
        'email',
        'phone',
        'resume_cv',
        'cover_letter',
        'interview_date',
        'interview_notes',
        'interview_score',
        'result_status'
    ];

    // Relationship with Interview
    public function interview()
    {
        return $this->belongsTo(Interviews::class, 'interview_id');
    }

    // InterviewResults model
    public function jobCandidates()
    {
        return $this->belongsTo(JobCandidates::class, 'candidate_id');
    }

    public function documentSubmission()
    {
        return $this->hasOne(DocumentSubmission::class, 'result_id', 'result_id');
    }

}
