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
        Schema::table('interviews', function (Blueprint $table) {
            $table->string('zoom_link')->nullable(); // Add zoom_link column
        });
    }

    public function down()
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('zoom_link'); // Drop column if migration is rolled back
        });
    }

};
