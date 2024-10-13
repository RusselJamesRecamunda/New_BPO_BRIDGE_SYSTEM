<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedJobsTable extends Migration
{
    public function up()
    {
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id('save_ID'); // Primary Key
            $table->unsignedBigInteger('user_id'); // Foreign Key referencing users table
            $table->unsignedBigInteger('full_job_id')->nullable(); // FK referencing full_time_job_postings
            $table->unsignedBigInteger('fl_job_id')->nullable(); // FK referencing freelance_job_postings
            $table->string('job_type_name'); // Column to store job type name
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('full_job_id')->references('full_job_ID')->on('full_time_job_postings')->onDelete('cascade');
            $table->foreign('fl_job_id')->references('fl_jobID')->on('freelance_job_postings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_jobs');
    }
}
