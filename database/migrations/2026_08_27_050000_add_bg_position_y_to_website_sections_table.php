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
        Schema::table('website_sections', function (Blueprint $table) {
            $table->integer('bg_position_y')->default(50)->nullable()->after('bg_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_sections', function (Blueprint $table) {
            $table->dropColumn('bg_position_y');
        });
    }
};
