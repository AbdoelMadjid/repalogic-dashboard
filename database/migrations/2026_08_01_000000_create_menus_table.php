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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('category')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('orders')->default(0);
            $table->foreignId('main_menu_id')->nullable()->constrained('menus')->onUpdate('no action')->onDelete('no action');
            $table->string('route')->nullable();
            $table->timestamps();
        });

        Schema::create('menu_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onUpdate('no action')->onDelete('no action');
            $table->foreignId('permission_id')->constrained('permissions')->onUpdate('no action')->onDelete('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_permission');
        Schema::dropIfExists('menus');
    }
};
