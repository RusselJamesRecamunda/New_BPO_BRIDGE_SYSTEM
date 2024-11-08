<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['category_name' => 'Data Analyst', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Developer', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Web Developer', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'IT Support', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'QA Tester', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Network Technician', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Tech Support', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'UI/UX Designer', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'System Admin', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Data Scientist', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
