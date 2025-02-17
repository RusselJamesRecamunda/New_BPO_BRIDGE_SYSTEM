<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCandidates extends Model
{
    use HasFactory;
    protected $primaryKey = 'candidate_id';

    protected $fillable = [
        'candidate_name',
        'candidate_email',
        'candidate_phone',
        'applied_job',
        'date_applied',
        'application_id',
        'application_status',
        'candidate_status',
        'candidate_resume',
        'candidate_cover_letter',
    ];

    // Relations
     public function application()
    {
        return $this->hasOne(Applications::class, 'application_id', 'application_id');
    }

    public function interview()
    {
        return $this->hasOne(Interviews::class, 'candidate_id', 'candidate_id');
    }

    // Relationship with Interview Results
    public function interviewResults()
    {
        return $this->hasMany(InterviewResults::class, 'candidate_id');
    }

}
