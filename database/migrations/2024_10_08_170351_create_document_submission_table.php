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
            $table->unsignedBigInteger('user_id');  // Foreign key (Mandatory)
            $table->string('nbi_clearance')->nullable();
            $table->string('medical_record')->nullable();
            $table->string('photo')->nullable();
            $table->string('resume')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('sss')->nullable();
            $table->string('tin')->nullable();
            $table->string('pagibig')->nullable();
            $table->string('philhealth')->nullable();
            $table->boolean('signed_contract')->default(false);
            $table->timestamps();

            // Mandatory foreign key
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_submissions');
    }
};
