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
            if (!Schema::hasColumn('user_configs', 'motto_color')) {
                $table->string('motto_color', 50)->nullable()->default('#ffffff')->after('motto');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_configs', function (Blueprint $table) {
            if (Schema::hasColumn('user_configs', 'motto_color')) {
                $table->dropColumn('motto_color');
            }
        });
    }
};
