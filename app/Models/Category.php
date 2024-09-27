<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name'];

    // Relationship with FullTimeJobPosting
    public function fullTimeJobPostings()
    {
        return $this->hasMany(FullTimeJobPosting::class, 'category_id');
    }

    // Relationship with FreelanceJobPosting
    public function freelanceJobPostings()
    {
        return $this->hasMany(FreelanceJobPosting::class, 'fl_category_id');
    }
}
