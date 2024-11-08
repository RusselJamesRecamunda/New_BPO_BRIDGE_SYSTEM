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
        Schema::create('full_time_job_postings', function (Blueprint $table) {
            $table->id('full_job_ID'); // Primary key for the job postings
            $table->string('job_title'); // Title of the job
            $table->text('job_description'); // Description of the job (changed from string to text)
            $table->foreignId('category_id') // Foreign key to categories table
                  ->constrained('categories', 'category_id')
                  ->onDelete('cascade');
            $table->foreignId('job_type_id') // Foreign key to job_types table
                  ->constrained('job_types', 'job_type_id')
                  ->onDelete('cascade');
            $table->foreignId('user_id') // Foreign key to users table
                  ->nullable() // Make it nullable
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');
            $table->string('job_location'); // Location of the job
            $table->text('requirements')->nullable(); // Requirements for the job
            $table->string('basic_pay')->nullable(); // Basic pay for the job
            $table->text('company_benefits')->nullable(); // Benefits provided by the company
            $table->text('keywords')->nullable(); // Keywords for the job
            $table->boolean('is_active')->default(true); // Status of the job posting
            $table->integer('max_hires'); // Maximum number of hires
            $table->text('job_photo')->nullable(); // Path to the job photo (png or jpg)
            $table->date('creation_date')->nullable(); // Date when the job was created
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('full_time_job_postings');
    }
};
