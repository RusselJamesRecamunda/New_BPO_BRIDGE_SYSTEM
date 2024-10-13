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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('emp_id'); // Primary key
            $table->foreignId('admin_id') // Foreign key referencing admin_info
                ->constrained('admin_info', 'admin_id') // References admin_id in admin_info
                ->onDelete('cascade'); // Delete employees if admin is deleted
            
            $table->string('official_emp_id')->unique(); // Unique official employee ID
            $table->string('first_name'); // First name
            $table->string('middle_name')->nullable(); // Middle name
            $table->string('last_name'); // Last name
            $table->string('email')->unique(); // Unique email
            $table->enum('gender', ['Male', 'Female', 'Other']); // Gender
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable(); // Marital status
            $table->string('phone_no'); // Phone number
            $table->text('address'); // Address
            $table->date('date_of_birth'); // Date of birth
            $table->string('role'); // Role of the employee
            $table->string('project_department'); // Project department
            $table->string('manager')->nullable(); // Manager's name
            
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
