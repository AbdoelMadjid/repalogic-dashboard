<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class RenameIndexToFolderName extends Command
{
    protected $signature = 'cp:rename-index-to-folder
                            {path=resources/views : Folder target}';

    protected $description = 'Mengganti index.blade.php menjadi nama foldernya';

    public function handle()
    {
        $path = base_path($this->argument('path'));

        if (!is_dir($path)) {
            $this->error('Folder tidak ditemukan.');
            return Command::FAILURE;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {

            if (
                !$file->isFile() ||
                $file->getFilename() !== 'index.blade.php'
            ) {
                continue;
            }

            $folderName = basename($file->getPath());
            $newPath = $file->getPath() . DIRECTORY_SEPARATOR . $folderName . '.blade.php';

            if (file_exists($newPath)) {
                $this->warn("↷ Skip (sudah ada): {$folderName}.blade.php");
                continue;
            }

            if (rename($file->getPathname(), $newPath)) {
                $this->info("✔ {$file->getPathname()} → {$folderName}.blade.php");
            } else {
                $this->error("✖ Gagal rename: {$file->getPathname()}");
            }
        }

        $this->info('✅ Semua index.blade.php berhasil disesuaikan dengan nama folder.');
        return Command::SUCCESS;
    }
}
