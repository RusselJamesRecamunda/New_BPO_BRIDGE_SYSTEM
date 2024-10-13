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
        'candidate_name',
        'applied_job',
        'interview_mode',
        'email',
        'phone',
        'interview_date',
        'interview_time'
    ];

    // Relationship with Admin Information (admin)
    public function admin()
    {
        return $this->belongsTo(AdminInfo::class, 'admin_id');
    } 

    // Relationship with Interview Results
    public function interviewResults()
    {
        return $this->hasMany(InterviewResults::class, 'interview_id');
    }
}
