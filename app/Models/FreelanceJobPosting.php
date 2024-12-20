<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelanceJobPosting extends Model 
{
    use HasFactory; 

    protected $table = 'freelance_job_postings'; // Specify the table name

    protected $primaryKey = 'fl_jobID'; 

    // Using $casts
    protected $casts = [
        'creation_date' => 'datetime',
    ];
    protected $fillable = [
        'fl_jobID',
        'fl_job_title',
        'fl_job_description',
        'fl_category_id',
        'fl_job_type_id', 
        'fl_user_id', 
        'fl_job_location',
        'fl_requirements',
        'fl_basic_pay',
        'fl_company_benefits',
        'max_hires',
        'job_duration',
        'job_photo',
        'job_status',
        'keywords',
        'creation_date',
    ];

    public $timestamps = false; // Assuming no created_at or updated_at columns

    // Define relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'fl_category_id');
    }
 
    // Define relationship with JobType
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'fl_job_type_id');
    }
 
    // Relationship with Applications
    public function applications()
    {
        return $this->hasMany(Applications::class, 'fl_jobID', 'fl_jobID');
    }

    // Relationship with SavedJobs
    public function savedJobs()
    {
        return $this->hasMany(SavedJobs::class, 'fl_job_id', 'fl_jobID');
    }

}
