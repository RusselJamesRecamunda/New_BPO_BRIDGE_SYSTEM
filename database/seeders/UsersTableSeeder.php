<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin user data
        User::create([
            'user_id' => 1, // 'user_id' is a custom primary key
            'first_name' => 'BPO-BRIDGE',
            'last_name' => 'Admin',
            'email' => 'bpobridge2024@gmail.com',
            'password' => bcrypt('JobPortalSystem2024'),
            'role' => 'admin',
        ]);
        User::create([
            'first_name' => 'Sample',
            'last_name' => '2',
            'email' => 'sample20@gmail.com',
            'password' => bcrypt('sample123'),
            'role' => 'applicant',
        ]);
        User::create([
            'first_name' => 'Sample',
            'last_name' => '3',
            'email' => 'sample21@gmail.com',
            'password' => bcrypt('sample123'),
            'role' => 'applicant',
        ]);
        
    }
}
