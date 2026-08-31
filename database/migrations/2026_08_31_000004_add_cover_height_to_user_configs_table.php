<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_configs', function (Blueprint $table) {
            $table->integer('cover_height')->default(320)->after('cover_position_y');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_configs', function (Blueprint $table) {
            $table->dropColumn('cover_height');
        });
    }
};
