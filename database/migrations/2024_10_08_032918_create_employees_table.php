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
            
            $table->text('emp_pic')->nullable(); 
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name'); 
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('date_of_birth'); 
            $table->string('marital_status')->nullable();
            $table->string('gender')->nullable();
            $table->text('complete_address'); 
            $table->timestamps(); 
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
