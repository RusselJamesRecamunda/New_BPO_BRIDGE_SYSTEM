<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            
            // Foreign key to admin_info table
            $table->foreignId('admin_id')
                  ->constrained('admin_info', 'admin_id') // FK constraint to admin_info table
                  ->onDelete('cascade'); // Delete report if admin is deleted
            
            // Foreign key to employees table
            $table->foreignId('emp_id')
                  ->constrained('employees', 'emp_id') // FK constraint to employees table
                  ->onDelete('cascade'); // Delete report if employee is deleted

            // Other fields based on the image
            $table->string('emp_first_name')->nullable();
            $table->string('emp_middle_name')->nullable();
            $table->string('emp_last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('official_emp_id')->nullable();
            $table->string('project_department')->nullable();
            
            // Manager details
            $table->string('manager_first_name')->nullable();
            $table->string('manager_middle_name')->nullable();
            $table->string('manager_last_name')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
