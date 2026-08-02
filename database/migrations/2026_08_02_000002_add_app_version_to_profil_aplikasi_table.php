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
        if (Schema::hasTable('profil_aplikasi') && !Schema::hasColumn('profil_aplikasi', 'app_version')) {
            Schema::table('profil_aplikasi', function (Blueprint $table) {
                $table->string('app_version')->default('v1.9.0')->nullable()->after('app_short_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('profil_aplikasi') && Schema::hasColumn('profil_aplikasi', 'app_version')) {
            Schema::table('profil_aplikasi', function (Blueprint $table) {
                $table->dropColumn('app_version');
            });
        }
    }
};
