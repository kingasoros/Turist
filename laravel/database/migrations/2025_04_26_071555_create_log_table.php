<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log', function (Blueprint $table) {
            // primer kulcs, nem auto_increment
            $table->integer('id_log')->primary();

            $table->string('user_agent', 255);
            $table->string('ip_address', 42);
            $table->string('country', 128);
            $table->dateTime('date_time')->useCurrent();
            $table->enum('device_type', ['phone', 'tablet', 'computer']);
            $table->boolean('proxy');
            $table->string('isp', 120);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log');
    }
}
