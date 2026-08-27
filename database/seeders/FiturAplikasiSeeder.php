<?php

namespace Database\Seeders;

use App\Models\Admin\DukunganAplikasi\FiturAplikasi;
use Illuminate\Database\Seeder;

class FiturAplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FiturAplikasi::clearCache();

        $features = [
            // ==========================================
            // KELOMPOK: TOPBAR HEADER
            // ==========================================
            [
                'kode_fitur' => 'topbar_search_box',
                'nama_fitur' => 'Pencarian (Search Box)',
                'kategori' => 'topbar',
                'deskripsi' => 'Kotak pencarian global pada topbar header',
                'icon' => 'ti ti-search',
                'status' => true,
                'urutan' => 1,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_megamenu_header',
                'nama_fitur' => 'Mega Menu Header',
                'kategori' => 'topbar',
                'deskripsi' => 'Dropdown navigasi mega menu header di topbar',
                'icon' => 'ti ti-layout-grid',
                'status' => false,
                'urutan' => 2,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_megamenu_apps',
                'nama_fitur' => 'Mega Menu Apps',
                'kategori' => 'topbar',
                'deskripsi' => 'Menu pintas aplikasi pada mega menu topbar',
                'icon' => 'ti ti-apps',
                'status' => false,
                'urutan' => 3,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_theme_toggler',
                'nama_fitur' => 'Theme Light/Dark Switcher',
                'kategori' => 'topbar',
                'deskripsi' => 'Tombol pengalih mode tema terang dan gelap',
                'icon' => 'ti ti-sun-moon',
                'status' => true,
                'urutan' => 4,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_apps_dropdown',
                'nama_fitur' => 'Apps Grid Shortcut',
                'kategori' => 'topbar',
                'deskripsi' => 'Dropdown grid shortcut aplikasi eksternal di topbar',
                'icon' => 'ti ti-grid-dots',
                'status' => false,
                'urutan' => 5,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_messages',
                'nama_fitur' => 'Pesan / Messages',
                'kategori' => 'topbar',
                'deskripsi' => 'Dropdown pemberitahuan pesan masuk di topbar',
                'icon' => 'ti ti-messages',
                'status' => true,
                'urutan' => 6,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_notifications',
                'nama_fitur' => 'Notifikasi Alert',
                'kategori' => 'topbar',
                'deskripsi' => 'Dropdown lonceng notifikasi dan peringatan sistem',
                'icon' => 'ti ti-bell',
                'status' => true,
                'urutan' => 7,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_fullscreen',
                'nama_fitur' => 'Mode Fullscreen',
                'kategori' => 'topbar',
                'deskripsi' => 'Tombol beralih ke mode layar penuh (fullscreen)',
                'icon' => 'ti ti-maximize',
                'status' => true,
                'urutan' => 8,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_monochrome',
                'nama_fitur' => 'Mode Monochrome',
                'kategori' => 'topbar',
                'deskripsi' => 'Tombol pengalih mode warna hitam-putih (monokrom)',
                'icon' => 'ti ti-contrast',
                'status' => true,
                'urutan' => 9,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_customizer',
                'nama_fitur' => 'Customizer / Theme Settings',
                'kategori' => 'topbar',
                'deskripsi' => 'Tombol panel pengaturan tema, layout, dan warna sidebar',
                'icon' => 'ti ti-settings-2',
                'status' => false,
                'urutan' => 10,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'topbar_language',
                'nama_fitur' => 'Pemilih Bahasa (Language)',
                'kategori' => 'topbar',
                'deskripsi' => 'Dropdown pemilihan bahasa antarmuka aplikasi (i18n)',
                'icon' => 'ti ti-language',
                'status' => true,
                'urutan' => 11,
                'is_system' => true,
            ],

            // ==========================================
            // KELOMPOK: MENU GROUP SIDEBAR TEMPLATE
            // ==========================================
            [
                'kode_fitur' => 'menu_group_main',
                'nama_fitur' => 'Group Menu: MAIN',
                'kategori' => 'menu_group',
                'deskripsi' => 'Kelompok menu dashboard template (Analytics, CRM, dll)',
                'icon' => 'ti ti-home',
                'status' => false,
                'urutan' => 13,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'menu_group_apps',
                'nama_fitur' => 'Group Menu: APPS',
                'kategori' => 'menu_group',
                'deskripsi' => 'Kelompok menu aplikasi template (Calendar, Chat, Email, dll)',
                'icon' => 'ti ti-brand-hipchat',
                'status' => false,
                'urutan' => 14,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'menu_group_custom_pages',
                'nama_fitur' => 'Group Menu: PAGES',
                'kategori' => 'menu_group',
                'deskripsi' => 'Kelompok menu halaman kustom template (Auth, Error, dll)',
                'icon' => 'ti ti-file-description',
                'status' => false,
                'urutan' => 15,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'menu_group_layouts',
                'nama_fitur' => 'Group Menu: LAYOUTS',
                'kategori' => 'menu_group',
                'deskripsi' => 'Kelompok menu demo layout template (Horizontal, Detached, dll)',
                'icon' => 'ti ti-layout-grid-add',
                'status' => false,
                'urutan' => 16,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'menu_group_components',
                'nama_fitur' => 'Group Menu: COMPONENTS',
                'kategori' => 'menu_group',
                'deskripsi' => 'Kelompok menu komponen UI template (Forms, Tables, Charts, dll)',
                'icon' => 'ti ti-components',
                'status' => false,
                'urutan' => 17,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'menu_group_documentation',
                'nama_fitur' => 'Group Menu: DOCUMENTATION',
                'kategori' => 'menu_group',
                'deskripsi' => 'Kelompok menu dokumentasi bawaan template & changelog',
                'icon' => 'ti ti-books',
                'status' => false,
                'urutan' => 18,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'menu_group_menu_item',
                'nama_fitur' => 'Group Menu: OTHER MENU ITEMS',
                'kategori' => 'menu_group',
                'deskripsi' => 'Kelompok menu bertingkat multi-level & item disabled',
                'icon' => 'ti ti-list-details',
                'status' => false,
                'urutan' => 19,
                'is_system' => true,
            ],
            [
                'kode_fitur' => 'menu_special_menu',
                'nama_fitur' => 'Menu Spesial (Special Menu)',
                'kategori' => 'menu_group',
                'deskripsi' => 'Tombol menu spesial ber-highlight di bagian bawah sidebar',
                'icon' => 'ti ti-star',
                'status' => true,
                'urutan' => 20,
                'is_system' => true,
            ],
        ];

        foreach ($features as $feat) {
            FiturAplikasi::updateOrCreate(
                ['kode_fitur' => $feat['kode_fitur']],
                $feat
            );
        }

        FiturAplikasi::clearCache();
    }
}
