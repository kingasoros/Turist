<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterSearchStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filter_search_statistics', function (Blueprint $table) {
            // ha szeretnéd pontosan int(11)-es PK-ként:
            $table->increments('id');

            $table->string('filter_name', 255);
            $table->string('filter_value', 255);
            $table->integer('count');
            
            // ha nem szeretnél created_at/updated_at oszlopot, akkor ne írd be a timestamps()-t
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_search_statistics');
    }
}
