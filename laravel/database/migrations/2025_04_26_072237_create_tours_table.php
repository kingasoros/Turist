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
        Schema::create('tours', function (Blueprint $table) {
            $table->id('tour_id');  // Automatikusan létrehozza az 'id' mezőt, vagy itt megadhatod a 'tour_id'-t.
            $table->string('tour_name');
            $table->text('tour_description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['private', 'public'])->default('private');
            $table->timestamps();  // Ez automatikusan létrehozza a created_at és updated_at mezőket
            $table->integer('favorites_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
};
