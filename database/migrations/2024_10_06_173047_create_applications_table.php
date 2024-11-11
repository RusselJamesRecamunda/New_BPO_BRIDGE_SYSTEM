<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id('application_id'); // Primary Key
            $table->date('app_date'); // Application date
            $table->string('applicant_name'); // Applicant's name
            $table->string('applicant_email'); // Applicant's email
            $table->string('applicant_phone'); // Applicant's phone
            $table->string('applicant_location'); // Applicant's location
            $table->enum('job_type', ['Full-time', 'Freelance']); // Job type
            $table->string('job_category'); // Job category
            $table->string('resume_cv'); // Resume/CV
            $table->string('cover_letter'); // Cover letter
            $table->string('applicant_emp_status'); // Applicant employment status
            $table->string('application_status'); // Application status
            $table->foreignId('user_id') // Foreign key to users table
            ->nullable() // Make it nullable
            ->constrained('users', 'user_id')
            ->onDelete('cascade');
            $table->foreignId('full_job_ID') // Foreign key to full time job postings table
            ->nullable() // Make it nullable
            ->constrained('full_time_job_postings', 'full_job_ID')
            ->onDelete('cascade');
            $table->foreignId('fl_jobID') // Foreign key to freelance job postings table
            ->nullable() // Make it nullable
            ->constrained('freelance_job_postings', 'fl_jobID')
            ->onDelete('cascade');
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
