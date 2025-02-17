<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullTimeJobPosting extends Model
{
    use HasFactory;
 
    protected $table = 'full_time_job_postings'; // Specify the table name
    
    protected $primaryKey = 'full_job_ID'; 

    // Using $casts
    protected $casts = [
        'creation_date' => 'datetime',
    ]; 

    protected $fillable = [ 
        'full_job_ID',
        'job_title',
        'job_description',
        'category_id',
        'job_type_id',
        'user_id',
        'job_location',
        'requirements', 
        'basic_pay',
        'company_benefits',
        'max_hires',
        'job_photo',
        'job_status',
        'keywords',
        'creation_date',
    ];

    public $timestamps = false; // Assuming no created_at or updated_at columns

    // Define relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Define relationship with JobType 
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    // Relationship with Applications
    public function applications()
    {
        return $this->hasMany(Applications::class,'full_job_ID'. 'full_jobID');
    }

    // Relationship with SavedJobs
    public function savedJobs()
    {
        return $this->hasMany(SavedJobs::class, 'full_job_id', 'full_job_ID');
    }

}

