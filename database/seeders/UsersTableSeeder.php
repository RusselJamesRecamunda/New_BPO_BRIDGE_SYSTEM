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
            'first_name' => 'BPO-Bridge',
            'last_name' => 'Admin',
            'email' => 'bpobridge2024@gmail.com',
            'password' => bcrypt('JobPortalSystem2024'),
            'role' => 'admin',
        ]);
    }
}
