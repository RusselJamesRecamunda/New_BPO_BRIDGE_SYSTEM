<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations. 
     */
    public function up(): void
    {
        Schema::create('freelance_job_postings', function (Blueprint $table) {
            $table->id('fl_jobID'); // Primary key for the job postings
            $table->string('fl_job_title'); // Title of the job
            $table->text('fl_job_description'); // Description of the job
            $table->foreignId('fl_category_id') // Foreign key to categories table
                  ->constrained('categories', 'category_id')
                  ->onDelete('cascade');
            $table->foreignId('fl_job_type_id') // Foreign key to job_types table
                  ->constrained('job_types', 'job_type_id')
                  ->onDelete('cascade');
            $table->foreignId('fl_user_id') // Foreign key to users table
                  ->nullable() // Make it nullable
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');
            $table->string('fl_job_location'); // Location of the job
            $table->text('fl_requirements')->nullable(); // Requirements for the job
            $table->string('fl_basic_pay')->nullable(); // Basic pay for the job
            $table->text('fl_company_benefits')->nullable(); // Benefits provided by the company
            $table->text('keywords')->nullable(); // Keywords for the job
            $table->boolean('is_active')->default(true); // Status of the job posting
            $table->integer('max_hires'); // Maximum number of hires
            $table->string('job_duration')->nullable();
            $table->text('job_photo')->nullable(); // Path to the job photo (png or jpg)
            $table->timestamp('creation_date')->nullable(); // Date when the job was created
        });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelance_job_postings');
    }
};
