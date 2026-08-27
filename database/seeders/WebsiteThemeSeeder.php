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

        WebsiteTheme::clearCache();
    }
}
