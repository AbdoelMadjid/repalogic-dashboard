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
        Schema::create('profil_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('app_short_name')->nullable();
            $table->string('logo_lg')->nullable();
            $table->string('logo_sm')->nullable();
            $table->string('favicon')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_author')->nullable();
            $table->string('footer_text')->nullable();
            $table->string('created_year')->nullable();
            $table->string('developer_name')->nullable();
            $table->string('developer_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_aplikasi');
    }
};
