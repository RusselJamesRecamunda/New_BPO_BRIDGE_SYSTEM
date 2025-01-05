<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interview_results', function (Blueprint $table) {
            // Add nullable candidate_id column after interview_id
            $table->unsignedBigInteger('candidate_id')->nullable()->after('interview_id');
            
            // Add the foreign key constraint
            $table->foreign('candidate_id')->references('candidate_id')->on('job_candidates')->onDelete('set null');

            // Modify other columns to be nullable
            $table->string('interviewer')->nullable()->change();
            $table->string('resume_cv')->nullable()->change();
            $table->integer('interview_score')->nullable()->change();
            $table->string('result_status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interview_results', function (Blueprint $table) {
            // Drop the foreign key and candidate_id column
            $table->dropForeign(['candidate_id']);
            $table->dropColumn('candidate_id');
            
            // Modify other columns to be non-nullable
            $table->string('interviewer')->nullable(false)->change();
            $table->string('resume_cv')->nullable(false)->change();
            $table->integer('interview_score')->nullable(false)->change();
            $table->string('result_status')->nullable(false)->change();
        });
    }
};
