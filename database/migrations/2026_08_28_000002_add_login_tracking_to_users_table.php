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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('login_count')->default(0)->after('reactivation_reason')->comment('Total akumulasi poin login');
            $table->timestamp('last_login_at')->nullable()->after('login_count')->comment('Waktu login terakhir');
            $table->timestamp('last_login_point_at')->nullable()->after('last_login_at')->comment('Waktu terakhir penambahan poin login (interval 24 jam)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_count', 'last_login_at', 'last_login_point_at']);
        });
    }
};
