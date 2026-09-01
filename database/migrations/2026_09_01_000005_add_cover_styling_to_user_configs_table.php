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
            if (!Schema::hasColumn('user_configs', 'cover_color')) {
                $table->string('cover_color', 50)->nullable()->default('#313a46')->after('cover_height');
            }
            if (!Schema::hasColumn('user_configs', 'cover_opacity')) {
                $table->integer('cover_opacity')->default(60)->after('cover_color');
            }
            if (!Schema::hasColumn('user_configs', 'cover_blur')) {
                $table->integer('cover_blur')->default(0)->after('cover_opacity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_configs', function (Blueprint $table) {
            $table->dropColumn(['cover_color', 'cover_opacity', 'cover_blur']);
        });
    }
};
