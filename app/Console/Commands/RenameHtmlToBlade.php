<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class RenameHtmlToBlade extends Command
{
    protected $signature = 'cp:blade {path=resources/views}';
    protected $description = 'Convert all .html files (recursive) to .blade.php in given folder';

    public function handle()
    {
        $path = base_path($this->argument('path'));

        if (!is_dir($path)) {
            $this->error("Folder {$path} tidak ditemukan.");
            return;
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'html') {
                $oldName = $file->getPathname();
                $newName = substr($oldName, 0, -5) . '.blade.php'; // ganti .html → .blade.php

                if (rename($oldName, $newName)) {
                    $this->info("Renamed: " . $oldName . " → " . $newName);
                } else {
                    $this->error("Gagal rename: " . $oldName);
                }
            }
        }

        $this->info('✅ Semua file .html sudah diubah jadi .blade.php (recursive).');
    }
}
