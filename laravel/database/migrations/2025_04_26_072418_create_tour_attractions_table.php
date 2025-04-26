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
        Schema::create('tour_attractions', function (Blueprint $table) {
            $table->integer('id')->primary(); // Kézzel kezeljük az 'id' mezőt, nem auto-increment
            $table->integer('tour_id');
            $table->integer('attractions_id');
            $table->integer('attraction_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_attractions');
    }
};
