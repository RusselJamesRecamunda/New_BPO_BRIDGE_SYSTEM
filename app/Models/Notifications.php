<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $primaryKey = 'notif_id'; // Set primary key

    protected $fillable = [
        'user_id',      // Foreign key for user or admin
        'user_type',    // Indicates if the notification is for a user or admin
        'message',      // Notification message
        'type',         // Type of notification
        'is_read',      // Read status
        'delivery_type', // Delivery method
    ];

    /**
     * Defines the relationship between Notification and User.
     * 
     * Each notification belongs to one user or admin.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
