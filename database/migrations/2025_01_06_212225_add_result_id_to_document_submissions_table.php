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
        Schema::table('document_submissions', function (Blueprint $table) {
            $table->unsignedBigInteger('result_id')->after('user_id'); // Add result_id column after user_id
            $table->foreign('result_id') // Add foreign key constraint
                ->references('result_id')
                ->on('interview_results')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('document_submissions', function (Blueprint $table) {
            $table->dropForeign(['result_id']); // Drop the foreign key
            $table->dropColumn('result_id'); // Drop the result_id column
        });
    }
};
