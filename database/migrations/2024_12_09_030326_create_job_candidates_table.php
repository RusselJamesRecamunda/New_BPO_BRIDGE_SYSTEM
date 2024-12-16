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
        Schema::create('job_candidates', function (Blueprint $table) {
            $table->id('candidate_id');
            $table->unsignedBigInteger('application_id');
            $table->string('candidate_name');
            $table->string('candidate_email');
            $table->string('candidate_phone');
            $table->string('applied_job');
            $table->date('date_applied');
            $table->string('application_status');
            $table->string('candidate_status');
            $table->timestamps();

            // Foreign keys
            $table->foreign('application_id')->references('application_id')->on('applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_candidates');
    }
};
