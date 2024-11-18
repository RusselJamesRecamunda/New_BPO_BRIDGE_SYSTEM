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
            $table->id('application_id');
            $table->date('app_date');
            $table->string('applicant_name');
            $table->string('applicant_email');
            $table->string('applicant_phone');
            $table->string('applicant_location')->nullable();
            $table->enum('job_type', ['Full-time', 'Freelance']);
            $table->string('job_category');
            $table->text('resume_cv'); // File path for resume
            $table->text('cover_letter')->nullable(); // File path for cover letter
            $table->string('applicant_emp_status');
            $table->string('application_status');
            
            $table->foreignId('user_id')
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');
            
            $table->foreignId('full_job_ID')
                  ->nullable()
                  ->constrained('full_time_job_postings', 'full_job_ID')
                  ->onDelete('cascade');
            
            $table->foreignId('fl_jobID')
                  ->nullable()
                  ->constrained('freelance_job_postings', 'fl_jobID')
                  ->onDelete('cascade');
        
            $table->timestamps();
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
