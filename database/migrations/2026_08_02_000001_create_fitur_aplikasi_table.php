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
        Schema::dropIfExists('fitur_aplikasi');

        Schema::create('fitur_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_fitur', 100)->unique();
            $table->string('nama_fitur', 255);
            $table->string('kategori', 100)->default('topbar')->index();
            $table->text('deskripsi')->nullable();
            $table->string('icon', 100)->nullable();
            $table->boolean('status')->default(true)->index();
            $table->integer('urutan')->default(0);
            $table->boolean('is_system')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitur_aplikasi');
    }
};
