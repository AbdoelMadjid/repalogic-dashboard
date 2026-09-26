<?php

namespace Database\Seeders;

use App\Models\Admin\DukunganAplikasi\WebsiteSection;
use App\Models\Admin\DukunganAplikasi\WebsiteTheme;
use Illuminate\Database\Seeder;

class WebsiteThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $theme = WebsiteTheme::updateOrCreate(
            ['slug' => 'default'],
            [
                'name' => 'Default Inspinia Classic',
                'folder' => 'default',
                'description' => 'Tema tampilan landing page bawaan template Inspinia Bootstrap 5.',
                'is_active' => true,
                'settings' => [
                    'type' => 'onepage',
                ],
            ]
        );

        $sections = [
            [
                'section_name' => 'Hero Banner Header',
                'section_key' => 'hero',
                'section_file' => 'section-hero.blade.php',
                'nav_title' => 'Home',
                'target_id' => 'hero',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 1,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Layanan & Fitur Unggulan (Services)',
                'section_key' => 'services',
                'section_file' => 'section-service.blade.php',
                'nav_title' => 'Services',
                'target_id' => 'services',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 2,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Fitur & Keunggulan Sistem (Features)',
                'section_key' => 'features',
                'section_file' => 'section-features.blade.php',
                'nav_title' => 'Features',
                'target_id' => 'features',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 3,
                'bg_type' => 'light',
                'bg_color_class' => 'bg-light bg-opacity-30 border-top border-bottom border-light',
            ],
            [
                'section_name' => 'Paket Layanan & Harga (Plans)',
                'section_key' => 'plans',
                'section_file' => 'section-plans.blade.php',
                'nav_title' => 'Plans',
                'target_id' => 'plans',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 4,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Call to Action Banner (CTA)',
                'section_key' => 'cta',
                'section_file' => 'section-cta.blade.php',
                'nav_title' => 'CTA',
                'target_id' => 'cta',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 5,
                'bg_type' => 'image',
                'bg_color_class' => 'website-section-bg-image text-white',
                'bg_image' => 'sections/landing-cta.jpg',
            ],
            [
                'section_name' => 'Ulasan & Testimoni Pelanggan (Reviews)',
                'section_key' => 'reviews',
                'section_file' => 'section-reviews.blade.php',
                'nav_title' => 'Reviews',
                'target_id' => 'reviews',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 6,
                'bg_type' => 'light',
                'bg_color_class' => 'bg-light bg-opacity-30 border-top border-bottom border-light',
            ],
            [
                'section_name' => 'Artikel & Berita Terbaru (Blog)',
                'section_key' => 'blog',
                'section_file' => 'section-blog.blade.php',
                'nav_title' => 'Blog',
                'target_id' => 'blog',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 7,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Form Kontak & Lokasi (Contact)',
                'section_key' => 'contact',
                'section_file' => 'section-contact.blade.php',
                'nav_title' => 'Contact',
                'target_id' => 'contact',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 8,
                'bg_type' => 'light',
                'bg_color_class' => 'bg-light bg-opacity-30 border-top border-bottom border-light',
            ],
        ];

        foreach ($sections as $sec) {
            WebsiteSection::updateOrCreate(
                [
                    'website_theme_id' => $theme->id,
                    'section_key' => $sec['section_key'],
                ],
                $sec
            );
        }

        // ==========================================
        // 2. TEMA EDUCATION (UNIFY EDUCATION PORTAL)
        // ==========================================
        $eduTheme = WebsiteTheme::updateOrCreate(
            ['slug' => 'education'],
            [
                'name' => 'Unify Education Portal',
                'folder' => 'education',
                'description' => 'Tema portal website kampus & institusi pendidikan multipage berbasis Unify.',
                'is_active' => false,
                'settings' => [
                    'type' => 'multipage',
                ],
            ]
        );

        $eduSections = [
            [
                'section_name' => 'Home Utama (Carousel & Intro)',
                'section_key' => 'home',
                'section_file' => 'home-page-1.blade.php',
                'nav_title' => 'Home',
                'target_id' => 'home',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 1,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Programs & Akademik (Programs)',
                'section_key' => 'programs',
                'section_file' => 'page-programs-1.blade.php',
                'nav_title' => 'Programs',
                'target_id' => 'programs',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 2,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Calon Mahasiswa (Future Students)',
                'section_key' => 'future-students',
                'section_file' => 'page-future-students-1.blade.php',
                'nav_title' => 'Future Students',
                'target_id' => 'future-students',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 3,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Mahasiswa Aktif (Current Students)',
                'section_key' => 'current-students',
                'section_file' => 'page-current-students-1.blade.php',
                'nav_title' => 'Current Students',
                'target_id' => 'current-students',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 4,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Dosen & Staf (Faculty & Staff)',
                'section_key' => 'faculty-and-staff',
                'section_file' => 'page-faculty-and-staff-1.blade.php',
                'nav_title' => 'Faculty & Staff',
                'target_id' => 'faculty-and-staff',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 5,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Agenda & Kegiatan Kampus (Events)',
                'section_key' => 'events',
                'section_file' => 'page-events-1.blade.php',
                'nav_title' => 'Events',
                'target_id' => 'events',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 6,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Ikatan Alumni Kampus (Alumni)',
                'section_key' => 'alumni',
                'section_file' => 'page-alumni-1.blade.php',
                'nav_title' => 'Alumni',
                'target_id' => 'alumni',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 7,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Kehidupan Kampus (Campus Life)',
                'section_key' => 'campus-life',
                'section_file' => 'page-campus-life-1.blade.php',
                'nav_title' => 'Campus Life',
                'target_id' => 'campus-life',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 8,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Riset & Penelitian (Research)',
                'section_key' => 'research',
                'section_file' => 'page-research-1.blade.php',
                'nav_title' => 'Research',
                'target_id' => 'research',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 9,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Pendaftaran Online (Apply Now)',
                'section_key' => 'apply',
                'section_file' => 'page-apply-1.blade.php',
                'nav_title' => 'Apply',
                'target_id' => 'apply',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 10,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Bantuan & FAQ (Help)',
                'section_key' => 'help',
                'section_file' => 'page-help-1.blade.php',
                'nav_title' => 'Help',
                'target_id' => 'help',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 11,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Kontak & Informasi (Contacts)',
                'section_key' => 'contacts',
                'section_file' => 'page-contacts-1.blade.php',
                'nav_title' => 'Contacts',
                'target_id' => 'contacts',
                'show_in_nav' => true,
                'is_active' => true,
                'orders' => 12,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
            [
                'section_name' => 'Portal Autentikasi (Sign In)',
                'section_key' => 'signin',
                'section_file' => 'page-signin-1.blade.php',
                'nav_title' => 'Sign In',
                'target_id' => 'signin',
                'show_in_nav' => false,
                'is_active' => true,
                'orders' => 13,
                'bg_type' => 'default',
                'bg_color_class' => null,
            ],
        ];

        foreach ($eduSections as $sec) {
            WebsiteSection::updateOrCreate(
                [
                    'website_theme_id' => $eduTheme->id,
                    'section_key' => $sec['section_key'],
                ],
                $sec
            );
        }

        WebsiteTheme::clearCache();
    }
}
