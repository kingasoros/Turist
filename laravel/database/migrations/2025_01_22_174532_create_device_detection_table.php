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
        Schema::create('device_detection', function (Blueprint $table) {
            $table->id(); 
            $table->string('ip_address'); 
            $table->string('user_agent'); 
            $table->string('device_type'); 
            $table->timestamps(); 
        });
    }

    /**
     * A tábla törlése.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_detection');
    }
};
