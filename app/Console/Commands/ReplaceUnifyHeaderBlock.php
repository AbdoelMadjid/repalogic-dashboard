<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ReplaceUnifyHeaderBlock extends Command
{
    //example:
    //php artisan cp:replace-unify-header resources/views/unify/unify-main/home

    protected $signature = 'cp:replace-unify-header
                            {path=resources/views/unify/shortcodes/block : Folder target}';

    protected $description = 'Mengganti blok Header / Sidebar Navigation Unify dengan include header-shortcodes';

    public function handle()
    {
        $path = base_path($this->argument('path'));

        if (!is_dir($path)) {
            $this->error("Folder {$path} tidak ditemukan.");
            return Command::FAILURE;
        }

        $replacement = <<<BLADE
<!-- Header -->
@include('education.partials.header')
<!-- End Header -->
BLADE;

        $patterns = [
            // Header → End Header
            '/(?s)<!--\s*Header\s*-->.*?<!--\s*End Header\s*-->/',

            // Maviagator → End Navigator
            //'/(?s)<!--\s*Navigation\s*-->.*?<!--\s*End Navigation\s*-->/',

            // Sidebar Navigation
            //'/(?s)<!--\s*Shortcode Sidebar Navigation\s*-->.*?<!--\s*End Shortcode Sidebar Navigation\s*-->/',

            // Header → End Sidebar Navigation
            //'/(?s)<!--\s*Header\s*-->.*?<!--\s*End Shortcode Sidebar Navigation\s*-->/',

            // Header → End Sidebar Navigation
            //'/(?s)<!--\s*Sidebar Nav\s*-->.*?<!--\s*End Sidebar Nav\s*-->/',
        ];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path)
        );

        foreach ($iterator as $file) {
            if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            $content = file_get_contents($file->getPathname());
            $original = $content;

            foreach ($patterns as $pattern) {
                $content = preg_replace($pattern, $replacement, $content);
            }

            if ($content !== $original) {
                file_put_contents($file->getPathname(), $content);
                $this->info("✔ Refactored: " . $file->getFilename());
            } else {
                $this->line("↷ Skip: " . $file->getFilename());
            }
        }

        $this->info('✅ Semua blok header/sidebar berhasil direfactor.');
        return Command::SUCCESS;
    }
}
