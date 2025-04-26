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
        Schema::create('attractions', function (Blueprint $table) {
            $table->integer('attractions_id')->primary();
            $table->string('city_name', 255);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('created_by', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->enum('type', [
                'Múzeumok',
                'Természeti látnivalók',
                'Történelmi helyek',
                'Szórakoztató helyek',
                'Vallási helyek',
                'Kulturális események'
            ])->nullable();
            $table->enum('interest', [
                'Családbarát',
                'Kalandturizmus',
                'Kultúra és művészetek',
                'Gasztronómia',
                'Történelem',
                'Sport'
            ])->nullable();
            $table->decimal('price', 10, 2);
            $table->time('open');
            $table->time('closed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attractions');
    }
};
