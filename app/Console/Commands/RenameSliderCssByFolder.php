<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DirectoryIterator;

class RenameSliderCssByFolder extends Command
{
    protected $signature = 'cp:rename-slider-css
                            {path=public/slider/master-slider : Path master slider}';

    protected $description = 'Mengganti style.css menjadi nama folder pada setiap slider';

    public function handle()
    {
        $basePath = base_path($this->argument('path'));

        if (!is_dir($basePath)) {
            $this->error("Folder {$basePath} tidak ditemukan.");
            return Command::FAILURE;
        }

        foreach (new DirectoryIterator($basePath) as $folder) {

            if (!$folder->isDir() || $folder->isDot()) {
                continue;
            }

            $folderName = $folder->getFilename();
            $cssDir = $folder->getPathname() . '/assets/css';
            $oldCss = $cssDir . '/style.css';
            $newCss = $cssDir . '/' . $folderName . '.css';

            if (!is_dir($cssDir)) {
                $this->line("↷ Skip {$folderName} (tidak ada assets/css)");
                continue;
            }

            if (!file_exists($oldCss)) {
                $this->line("↷ Skip {$folderName} (style.css tidak ditemukan)");
                continue;
            }

            if (file_exists($newCss)) {
                $this->warn("↷ Skip {$folderName} ({$folderName}.css sudah ada)");
                continue;
            }

            if (rename($oldCss, $newCss)) {
                $this->info("✔ {$folderName}: style.css → {$folderName}.css");
            } else {
                $this->error("✖ Gagal rename di {$folderName}");
            }
        }

        $this->info("✅ Semua slider CSS selesai diproses.");
        return Command::SUCCESS;
    }
}
