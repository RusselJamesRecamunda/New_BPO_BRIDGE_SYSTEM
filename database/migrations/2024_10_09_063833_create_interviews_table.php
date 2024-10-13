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
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('admin_id')->references('admin_id')->on('admin_info')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('interviews');
    }
};
