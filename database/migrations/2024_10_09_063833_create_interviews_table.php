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
        // Create the 'interviews' table
        Schema::create('interviews', function (Blueprint $table) {
            $table->id('interview_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('candidate_name');
            $table->string('applied_job');
            $table->string('interview_mode');
            $table->string('email');
            $table->string('phone');
            $table->date('interview_date');
            $table->time('interview_time');
            $table->string('virtual_meet_link')->nullable();
            $table->string('onsite_phone')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('admin_id')->references('admin_id')->on('admin_info')->onDelete('cascade');
        });

        // Modify the 'admin_id' column to make it nullable
        Schema::table('interviews', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Reverse the modification of 'admin_id' column to make it not nullable
        Schema::table('interviews', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable(false)->change();
        });

        // Drop the 'interviews' table
        Schema::dropIfExists('interviews');
    }
};
