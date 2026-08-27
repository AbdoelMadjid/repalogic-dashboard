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
        Schema::create('website_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_theme_id')->constrained('website_themes')->onDelete('cascade');
            $table->string('section_name');
            $table->string('section_key');
            $table->string('section_file');
            $table->string('nav_title')->nullable();
            $table->string('target_id')->nullable();
            $table->boolean('show_in_nav')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('orders')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_sections');
    }
};
