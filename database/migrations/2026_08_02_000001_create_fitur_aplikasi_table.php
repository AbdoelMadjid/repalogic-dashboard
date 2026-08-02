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
        Schema::create('fitur_aplikasi', function (Blueprint $table) {
            $table->id();
            
            // Topbar Features
            $table->boolean('topbar_search_box')->default(true);
            $table->boolean('topbar_megamenu_header')->default(true);
            $table->boolean('topbar_megamenu_apps')->default(true);
            $table->boolean('topbar_theme_toggler')->default(true);
            $table->boolean('topbar_apps_dropdown')->default(true);
            $table->boolean('topbar_messages')->default(true);
            $table->boolean('topbar_notifications')->default(true);
            $table->boolean('topbar_fullscreen')->default(true);
            $table->boolean('topbar_monochrome')->default(true);
            $table->boolean('topbar_customizer')->default(true);
            $table->boolean('topbar_language')->default(true);
            $table->boolean('topbar_user_dropdown')->default(true);

            // Sidenav Group Menus (Template)
            $table->boolean('menu_group_main')->default(true);
            $table->boolean('menu_group_apps')->default(true);
            $table->boolean('menu_group_custom_pages')->default(true);
            $table->boolean('menu_group_layouts')->default(true);
            $table->boolean('menu_group_components')->default(true);
            $table->boolean('menu_group_documentation')->default(true);
            $table->boolean('menu_group_menu_item')->default(true);
            $table->boolean('menu_special_menu')->default(true);

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
