<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('interview_results', function (Blueprint $table) {
            $table->id('result_id');
            $table->unsignedBigInteger('interview_id');
            // $table->unsignedBigInteger('application_id');
            $table->string('applied_job');
            $table->string('candidate_name');
            $table->string('interviewer');
            $table->string('interview_mode');
            $table->string('email');
            $table->string('phone');
            $table->string('resume_cv');
            $table->string('cover_letter')->nullable();
            $table->date('interview_date');
            $table->text('interview_notes')->nullable();
            $table->integer('interview_score');
            $table->string('result_status');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('interview_id')->references('interview_id')->on('interviews')->onDelete('cascade');
            // $table->foreign('application_id')->references('application_id')->on('applications')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('interview_results');
    }
};
