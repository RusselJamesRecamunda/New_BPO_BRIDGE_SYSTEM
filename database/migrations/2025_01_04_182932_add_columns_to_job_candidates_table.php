<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToJobCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_candidates', function (Blueprint $table) {
            $table->string('candidate_resume')->nullable()->after('candidate_status');
            $table->string('candidate_cover_letter')->nullable()->after('candidate_resume');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_candidates', function (Blueprint $table) {
            $table->dropColumn(['candidate_resume', 'candidate_cover_letter']);
        });
    }
}
