<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterSearchStatisticsTable extends Migration
{
    public function up()
    {
        Schema::create('filter_search_statistics', function (Blueprint $table) {
            $table->id();  
            $table->string('city');
            $table->string('type');
            $table->string('interest');
            $table->timestamp('timestamp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('filter_search_statistics');
    }
}
