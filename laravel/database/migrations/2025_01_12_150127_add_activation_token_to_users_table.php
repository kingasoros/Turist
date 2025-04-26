<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'activation_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('activation_token', 64)->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'activation_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('activation_token');
            });
        }
    }
};
