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
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false)->after('deleted_for_receiver')->index();
            $table->json('reactions')->nullable()->after('is_pinned');
            $table->boolean('is_forwarded')->default(false)->after('reactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['is_pinned', 'reactions', 'is_forwarded']);
        });
    }
};
