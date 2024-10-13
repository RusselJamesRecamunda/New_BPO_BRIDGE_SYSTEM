<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Call the UsersTableSeeder first
         $this->call(UsersTableSeeder::class);

         // Call the AdminInfoTableSeeder after UsersTableSeeder
         $this->call(AdminInfoTableSeeder::class);

         // Call the JobTypeSeeder to insert Full-time and Freelance job types
        $this->call(JobTypeSeeder::class);
    }
}
