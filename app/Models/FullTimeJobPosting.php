<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullTimeJobPosting extends Model
{
    use HasFactory;
 
    protected $table = 'full_time_job_postings'; // Specify the table name

    protected $fillable = [
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
}

