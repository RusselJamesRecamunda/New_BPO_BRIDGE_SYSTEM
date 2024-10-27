<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class AdminInfo extends Model
{
    use HasFactory;

    protected $table = 'admin_info'; // Specify the table name
    protected $primaryKey = 'admin_id'; // Specify the primary key

    // Fillable properties for mass assignment
    protected $fillable = [
        'admin_fname',
        'admin_lname',
        'email',
        'user_id', // Foreign key reference
    ];

    // Define the relationship with the User model
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

      // One admin can have many employees
      public function employees()
      {
          return $this->hasMany(Employees::class, 'admin_id', 'admin_id');
      }

      // Define the one-to-many relationship with the reports
    public function reports()
    {
        return $this->hasMany(Reports::class, 'admin_id', 'admin_id');
    }
}
