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
        'nbi_clearance',
        'medical_record',
        'photo',
        'resume',
        'birth_certificate',
        'sss',
        'tin',
        'pagibig',
        'philhealth',
        'signed_contract',
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
}
