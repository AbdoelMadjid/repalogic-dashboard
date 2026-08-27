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
            $table->string('bg_type')->default('default')->after('orders');
            $table->string('bg_color_class')->nullable()->after('bg_type');
            $table->string('bg_image')->nullable()->after('bg_color_class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_sections', function (Blueprint $table) {
            $table->dropColumn(['bg_type', 'bg_color_class', 'bg_image']);
        });
    }
};
