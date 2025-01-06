<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSubmission extends Model
{
    use HasFactory;

    protected $primaryKey = 'doc_id'; // The primary key of the table

    protected $fillable = [
        'user_id',
        'result_id',
        '2x2_pic',
        'birth_certificate',
        'tin_number',
        'philhealth_id',
        'pagibig_membership_id',
        'sss',
        'bir_form',
        'health_cert',
    ];

    /**
     * Defines the relationship between DocumentSubmission and User.
     * 
     * Each document submission belongs to one user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function interviewResults()
    {
        return $this->belongsTo(InterviewResults::class, 'result_id', 'result_id');
    }
}
