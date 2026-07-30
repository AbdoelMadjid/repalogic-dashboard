<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class AssetHelperCommand extends Command
{
    protected $signature = 'asset:helper
                            {path=resources/views}
                            {--dry-run : Hanya melihat perubahan}
                            {--backup : Membuat backup file sebelum perubahan}';

    protected $description = 'Convert local asset/html path menjadi Laravel asset helper';

    protected array $attributes = [
        'href',
        'src',
        'poster',
        'data-src',
        'data-background',
        'data-bg',
        'data-thumb',
        'action',
    ];

    protected array $extensions = [
        'css',
        'js',
        'png',
        'jpg',
        'jpeg',
        'svg',
        'gif',
        'webp',
        'ico',
        'woff',
        'woff2',
        'ttf',
        'html',
    ];

    protected int $changedFiles = 0;

    protected int $changedAssets = 0;

    public function handle()
    {

        $path = base_path($this->argument('path'));

        if (! is_dir($path)) {

            $this->error('Folder tidak ditemukan : '.$path);

            return Command::FAILURE;
        }

        $this->info('Scanning : '.$path);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path)
        );

        foreach ($files as $file) {

            if ($file->isDir()) {
                continue;
            }

            if (! str_ends_with($file->getFilename(), '.blade.php')
                && $file->getExtension() !== 'html'
            ) {
                continue;
            }

            $this->processFile($file->getPathname());

        }

        $this->newLine();

        $this->info('Selesai');

        $this->line(
            'File berubah : '.$this->changedFiles
        );

        $this->line(
            'Asset berubah : '.$this->changedAssets
        );

        return Command::SUCCESS;
    }

    private function processFile($file)
    {

        $content = file_get_contents($file);

        $original = $content;

        foreach ($this->attributes as $attribute) {

            $pattern = '/'.$attribute.'="([^"]+)"/i';

            $content = preg_replace_callback(
                $pattern,
                function ($match) {

                    $value = $match[1];

                    if (! $this->shouldConvert($value)) {

                        return $match[0];
                    }

                    $this->changedAssets++;

                    return str_replace(
                        '"'.$value.'"',
                        '"{{ asset(\''.$value.'\') }}"',
                        $match[0]
                    );

                },
                $content
            );

        }

        if ($original !== $content) {

            if ($this->option('dry-run')) {

                $this->warn(
                    '[DRY] '.$file
                );

                return;
            }

            if ($this->option('backup')) {

                copy(
                    $file,
                    $file.'.bak'
                );

            }

            file_put_contents(
                $file,
                $content
            );

            $this->line(
                '✔ '.basename($file)
            );

            $this->changedFiles++;

        }

    }

    private function shouldConvert($value)
    {

        /*
        Jangan sentuh Blade
        */

        if (
            str_contains($value, '{{')
            ||
            str_contains($value, '{!!')
        ) {

            return false;
        }

        /*
        Jangan sentuh URL khusus
        */

        $ignore = [

            '#',
            'javascript:',
            'mailto:',
            'tel:',
            'http://',
            'https://',
            '//',
            'data:',
            'blob:',

        ];

        foreach ($ignore as $item) {

            if (str_starts_with($value, $item)) {

                return false;

            }

        }

        /*
        Ambil extension file
        */

        $path = parse_url(
            $value,
            PHP_URL_PATH
        );

        $extension = strtolower(
            pathinfo($path, PATHINFO_EXTENSION)
        );

        /*
        Hanya file tertentu
        */

        if (
            ! in_array(
                $extension,
                $this->extensions
            )
        ) {

            return false;

        }

        return true;

    }
}
