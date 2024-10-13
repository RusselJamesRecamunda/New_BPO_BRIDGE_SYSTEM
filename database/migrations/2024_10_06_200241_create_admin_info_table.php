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
        Schema::create('admin_info', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('admin_fname')->nullable();
            $table->string('admin_lname')->nullable();
            $table->string('email')->nullable();
            
            // Ensure the user_id column is a foreign key
            $table->foreignId('user_id')
                ->constrained('users', 'user_id') // References user_id in users table
                ->onDelete('cascade') // Delete admin_info if user is deleted
                ->unique(); // Ensure one-to-one relationship
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_info');
    }
};
