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
        Schema::table('interviews', function (Blueprint $table) {
            // Add the candidate_id column after the admin_id column
            $table->unsignedBigInteger('candidate_id')->nullable()->after('admin_id');

            // Define the foreign key reference to the job_candidates table
            $table->foreign('candidate_id')->references('candidate_id')->on('job_candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            // Drop the foreign key and candidate_id column
            $table->dropForeign(['candidate_id']);
            $table->dropColumn('candidate_id');
        });
    }
};
