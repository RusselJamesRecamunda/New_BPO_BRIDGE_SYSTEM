<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;

    protected $fillable = ['job_type_name'];

    protected $primaryKey = 'job_type_id';  // Correct primary key 

    // Relationship with FullTimeJobPosting
    public function fullTimeJobPostings()
    {
        return $this->hasMany(FullTimeJobPosting::class, 'job_type_id');
    }

    // Relationship with FreelanceJobPosting
    public function freelanceJobPostings()
    {
        return $this->hasMany(FreelanceJobPosting::class, 'fl_job_type_id');
    }
}
