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
        Schema::create('document_submissions', function (Blueprint $table) {
            $table->bigIncrements('doc_id');
            $table->unsignedBigInteger('user_id'); // Foreign key (Mandatory)
            $table->unsignedBigInteger('result_id'); // Foreign key for one-to-one relation
            $table->text('2x2_pic')->nullable();
            $table->text('birth_certificate')->nullable();
            $table->text('tin_number')->nullable();
            $table->text('philhealth_id')->nullable();
            $table->text('pagibig_membership_id')->nullable();
            $table->text('sss')->nullable();
            $table->text('bir_form')->nullable();
            $table->text('health_cert')->nullable();
            $table->timestamps();

            // Mandatory foreign keys
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('result_id')->references('result_id')->on('interview_results')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('document_submissions');
    }
};
