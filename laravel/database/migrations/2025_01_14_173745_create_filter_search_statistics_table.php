<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterSearchStatisticsTable extends Migration
{
    public function up()
    {
        Schema::create('search_records', function (Blueprint $table) {
            $table->id();  
            $table->string('city');
            $table->string('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('filter_search_statistics');
    }
}
