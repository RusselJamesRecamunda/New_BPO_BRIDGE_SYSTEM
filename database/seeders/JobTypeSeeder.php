<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('job_types')->insert([
            ['job_type_name' => 'Full-time', 'created_at' => now(), 'updated_at' => now()],
            ['job_type_name' => 'Freelance', 'created_at' => now(), 'updated_at' => now()],
            ['job_type_name' => 'Contractual', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
