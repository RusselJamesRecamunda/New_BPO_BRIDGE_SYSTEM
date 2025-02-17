<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'google_id',
        'phone_number',
        'address',
        'date_of_birth',
        'profile_summary',
        'skills',
        'role',
        'otp_code',
        'remember_token',
        'activity_status',
        'user_status',
        'user_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define a one-to-one relationship with AdminInfo.
     */
    public function adminInfo()
    {
        return $this->hasOne(AdminInfo::class, 'user_id', 'user_id');
    }

    // A user must have at least one document submission
    public function documentSubmissions()
    {
        return $this->hasMany(DocumentSubmission::class, 'user_id');
    }
    /**
     * Defines the relationship between User and Notifications.
     * 
     * A user can have many notifications.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notifications::class, 'user_id');
    }

    // Relationship with Contracts Table
    public function contract()
    {
        return $this->hasOne(Contract::class, 'user_id');
    }

    // Relationship with Applications
    public function applications()
    {
        return $this->hasMany(Applications::class, 'user_id');
    }

    // Relationship with SavedJobs
    public function savedJobs()
    {
        return $this->hasMany(SavedJobs::class, 'user_id', 'user_id');
    }
}
