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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notif_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key (to users or admins)
            $table->string('user_type'); // Indicates whether the notification is for 'user' or 'admin'
            $table->string('message'); // Notification message
            $table->string('type'); // Type of notification (e.g., alert, reminder)
            $table->boolean('is_read')->default(false); // Read status
            $table->string('delivery_type'); // Type of delivery (e.g., email, push)
            $table->timestamps(); // Created at and updated at timestamps

            // Define the foreign key constraint
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
