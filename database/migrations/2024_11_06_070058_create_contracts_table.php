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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id('contract_id'); // Primary Key
            $table->unsignedBigInteger('user_id')->unique(); // Foreign Key for users, with unique constraint
            $table->unsignedBigInteger('emp_id')->unique(); // Foreign Key for employees, with unique constraint
            $table->string('job_type_name');
            $table->string('contract_file');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('contract_status');
            $table->timestamps();
    
            // Foreign key constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
