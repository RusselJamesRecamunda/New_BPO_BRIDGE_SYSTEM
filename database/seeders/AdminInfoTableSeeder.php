<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminInfo;
use App\Models\User;

class AdminInfoTableSeeder extends Seeder
{ 
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example admin info data for user with user_id 1
        $user1 = User::find(1);  // Fetch user with user_id 1
        AdminInfo::create([ 
            'admin_fname' => $user1->first_name,
            'admin_lname' => $user1->last_name,
            'email' => $user1->email,
            'user_id' => $user1->user_id,  // Link to user_id in users table
        ]);
    }
}
