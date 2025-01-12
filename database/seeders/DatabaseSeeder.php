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
        // Call the RoleSeeder to insert admin and applicant roles
        $this->call(RoleSeeder::class);

        // Call the UsersTableSeeder first
        $this->call(UsersTableSeeder::class);

        // Call the AdminInfoTableSeeder after UsersTableSeeder
        $this->call(AdminInfoTableSeeder::class);

        // Call the JobTypeSeeder to insert Full-time and Freelance job types
        $this->call(JobTypeSeeder::class);

        // Call the CategorySeeder to insert job categories
        $this->call(CategorySeeder::class);
    }
}
