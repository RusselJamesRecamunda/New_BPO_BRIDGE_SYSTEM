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
        Schema::create('employee_assets', function (Blueprint $table) {
            $table->unsignedBigInteger('emp_id')->primary();
            $table->string('dept_manager')->nullable();
            $table->string('hire_date')->nullable();
            $table->string('official_emp_id')->nullable();
            $table->string('mst_account')->nullable();
            $table->string('emp_email')->nullable();
            $table->string('work_status')->nullable();
            $table->string('project_department')->nullable();
            $table->string('working_days')->nullable();
            $table->string('designation')->nullable();
            $table->text('birth_cert')->nullable();
            $table->text('phil_health')->nullable();
            $table->text('sss')->nullable();
            $table->text('tin_number')->nullable();
            $table->text('pagibig_membership')->nullable();
            
            // Foreign key constraint linking to the Employees table
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_assets');
    }
};
