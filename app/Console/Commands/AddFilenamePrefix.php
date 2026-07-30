<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class AddFilenamePrefix extends Command
{
    protected $signature = 'cp:add-prefix
                            {prefix : Prefix yang akan ditambahkan}
                            {path=resources/views : Path folder target}';

    protected $description = 'Menambahkan prefix ke nama file secara massal (recursive)';

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

            // Skip kalau sudah punya prefix
            if (str_starts_with($filename, $prefix)) {
                continue;
            }

            $oldPath = $file->getPathname();
            $newName = $prefix . $filename;
            $newPath = $file->getPath() . DIRECTORY_SEPARATOR . $newName;

            if (rename($oldPath, $newPath)) {
                $this->info("✔ {$filename} → {$newName}");
            } else {
                $this->error("✖ Gagal rename: {$filename}");
            }
        }

        $this->info("✅ Prefix '{$prefix}' berhasil ditambahkan.");
        return Command::SUCCESS;
    }
}
