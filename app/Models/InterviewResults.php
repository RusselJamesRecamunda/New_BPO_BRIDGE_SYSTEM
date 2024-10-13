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
        'application_id',
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

    // Relationship with Application
    public function application()
    {
        return $this->belongsTo(Applications::class, 'application_id');
    }
}
