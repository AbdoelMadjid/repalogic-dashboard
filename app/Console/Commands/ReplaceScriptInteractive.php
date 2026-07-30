<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ReplaceScriptInteractive extends Command
{
    protected $signature = 'cp:replace-script-i';

    protected $description = 'Replace isi script secara massal dengan mode interaktif';

    public function handle()
    {
        $search = $this->ask('Masukkan text yang ingin diganti');

        $replace = $this->ask('Masukkan text pengganti');

        $pathInput = $this->ask(
            'Masukkan folder target',
            'resources/views'
        );

        $path = base_path($pathInput);

        if (!is_dir($path)) {
            $this->error("Folder tidak ditemukan.");
            return;
        }

        if (!$this->confirm("Yakin ingin menjalankan replace di folder ini?", true)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path)
        );

        foreach ($iterator as $file) {

            if (!$file->isFile() || !str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            $fullPath = $file->getPathname();
            $content  = file_get_contents($fullPath);

            $newContent = str_replace($search, $replace, $content);

            if ($newContent !== $content) {
                file_put_contents($fullPath, $newContent);
                $this->info("✔ Updated: " . $file->getFilename());
            }
        }

        $this->info("✅ Replace selesai.");
    }
}
