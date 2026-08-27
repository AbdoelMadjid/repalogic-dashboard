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
            $table->string('bg_size', 50)->default('cover')->nullable()->after('bg_position_y');
            $table->string('bg_attachment', 50)->default('scroll')->nullable()->after('bg_size');
            $table->integer('bg_image_width')->nullable()->after('bg_attachment');
            $table->integer('bg_image_height')->nullable()->after('bg_image_width');
            $table->string('bg_image_orientation', 20)->nullable()->after('bg_image_height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_sections', function (Blueprint $table) {
            $table->dropColumn([
                'bg_size',
                'bg_attachment',
                'bg_image_width',
                'bg_image_height',
                'bg_image_orientation',
            ]);
        });
    }
};
