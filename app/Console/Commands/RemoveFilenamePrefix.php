<?php

namespace App\Console\Commands;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

use Illuminate\Console\Command;

class RemoveFilenamePrefix extends Command
{
    //example:
    //php artisan cp:remove-prefix "promo-" resources/views/templates/main/shortcodes/blocks

    protected $signature = 'cp:remove-prefix
                            {prefix : Teks prefix yang akan dihapus}
                            {path=resources/views : Path folder target}';

    protected $description = 'Menghapus prefix tertentu dari nama file secara massal (recursive)';

    public function handle()
    {
        $prefix = $this->argument('prefix');
        $path   = base_path($this->argument('path'));

        if (!is_dir($path)) {
            $this->error("Folder {$path} tidak ditemukan.");
            return Command::FAILURE;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path)
        );

        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }

            $filename = $file->getFilename();

            if (str_starts_with($filename, $prefix)) {
                $oldPath = $file->getPathname();
                $newName = substr($filename, strlen($prefix));
                $newPath = $file->getPath() . DIRECTORY_SEPARATOR . $newName;

                if (rename($oldPath, $newPath)) {
                    $this->info("✔ {$filename} → {$newName}");
                } else {
                    $this->error("✖ Gagal rename: {$filename}");
                }
            }
        }

        $this->info("✅ Prefix '{$prefix}' berhasil dihapus secara massal.");
        return Command::SUCCESS;
    }
}
