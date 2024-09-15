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
        Schema::create('job_shifts', function (Blueprint $table) {
            $table->id('shift_id'); // Primary key
            $table->string('shift_name'); // Name of the shift
            $table->time('start_time'); // Shift start time
            $table->time('end_time'); // Shift end time
            $table->timestamps(); // Laravel's created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_shifts');
    }
};
