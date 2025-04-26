<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turist_favorites', function (Blueprint $table) {
            $table->integer('favorite_id')->primary(); // nem auto-increment
            $table->unsignedBigInteger('id');           // user id
            $table->integer('tour_id');                 // tour id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turist_favorites');
    }
};
