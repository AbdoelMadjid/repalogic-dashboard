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
        Schema::create('user_media_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('media_type', 30); // avatar, cover
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('description')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'media_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_media_histories');
    }
};
