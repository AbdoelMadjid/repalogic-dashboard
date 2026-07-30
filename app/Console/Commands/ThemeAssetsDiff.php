<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ThemeAssetsDiff extends Command
{
    protected $signature = 'theme:assets-diff
        {theme_version : Versi tema, contoh: v3}
        {--source= : Folder sumber relatif ke public/. Default: assets-vN, fallback assets/vN}
        {--base=assets : Folder base assets relatif ke public/}
        {--dry-run : Simulasi tanpa mengubah file}
        {--keep-source : Jangan hapus folder sumber setelah proses}
        {--force : Timpa file css/js suffix versi jika sudah ada}';

    protected $description = 'Gabungkan asset versi ke assets base: css/js beda => suffix -vX, media sama => reuse base';

    public function handle(): int
    {
        $version = (string) $this->argument('theme_version');
        $baseRel = trim((string) $this->option('base'), '/\\');
        $sourceOpt = $this->option('source');
        $sourceRel = $sourceOpt ? trim((string) $sourceOpt, '/\\') : null;

        if ($version === '') {
            $this->error('Argumen {version} wajib diisi.');

            return self::FAILURE;
        }

        if (! preg_match('/^v[0-9]+$/', $version)) {
            $this->warn("Versi '$version' tidak mengikuti pola umum vN (mis. v3). Tetap dilanjutkan.");
        }

        if ($sourceRel === null) {
            $candidate1 = 'assets-'.$version;
            $candidate2 = $baseRel.'/'.$version;
            $sourceRel = is_dir(public_path($candidate1)) ? $candidate1 : $candidate2;
        }

        if ($sourceRel === $baseRel) {
            $this->error("Source ('$sourceRel') tidak boleh sama dengan base ('$baseRel').");

            return self::FAILURE;
        }

        $basePath = public_path($baseRel);
        $sourcePath = public_path($sourceRel);
        $dryRun = (bool) $this->option('dry-run');
        $keepSource = (bool) $this->option('keep-source');
        $force = (bool) $this->option('force');

        if (! is_dir($basePath)) {
            $this->error("Folder base tidak ditemukan: $basePath");

            return self::FAILURE;
        }

        if (! is_dir($sourcePath)) {
            $this->error("Folder source tidak ditemukan: $sourcePath");

            return self::FAILURE;
        }

        $this->info("Base   : public/$baseRel");
        $this->info("Source : public/$sourceRel");
        $this->info("Mode   : ".($dryRun ? 'DRY RUN' : 'APPLY'));

        $movedUnique = 0;
        $renamedCssJs = 0;
        $deletedSame = 0;
        $deletedDifferentMedia = 0;
        $skippedExists = 0;
        $errors = 0;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourcePath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if (! $item->isFile()) {
                continue;
            }

            $src = $item->getPathname();
            $rel = ltrim(str_replace('\\', '/', substr($src, strlen($sourcePath))), '/');
            $dest = $basePath.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $rel);
            $destDir = dirname($dest);

            if (! file_exists($dest)) {
                if (! $dryRun) {
                    if (! is_dir($destDir) && ! mkdir($destDir, 0777, true) && ! is_dir($destDir)) {
                        $this->error("Gagal membuat folder: $destDir");
                        $errors++;

                        continue;
                    }
                    rename($src, $dest);
                }
                $movedUnique++;

                continue;
            }

            if ($this->sameFile($src, $dest)) {
                if (! $dryRun) {
                    unlink($src);
                }
                $deletedSame++;

                continue;
            }

            $ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
            if (in_array($ext, ['css', 'js'], true)) {
                $filename = pathinfo($src, PATHINFO_FILENAME);
                $versionedDest = $destDir.DIRECTORY_SEPARATOR.$filename.'-'.$version.'.'.$ext;

                if (file_exists($versionedDest) && ! $force) {
                    $this->warn("Skip (sudah ada): ".str_replace('\\', '/', $versionedDest));
                    $skippedExists++;

                    continue;
                }

                if (! $dryRun) {
                    if (! is_dir($destDir) && ! mkdir($destDir, 0777, true) && ! is_dir($destDir)) {
                        $this->error("Gagal membuat folder: $destDir");
                        $errors++;

                        continue;
                    }
                    rename($src, $versionedDest);
                }
                $renamedCssJs++;
            } else {
                if (! $dryRun) {
                    unlink($src);
                }
                $deletedDifferentMedia++;
            }
        }

        if (! $dryRun && ! $keepSource) {
            $this->cleanupEmptyDirectories($sourcePath);
        }

        $this->newLine();
        $this->info('Ringkasan:');
        $this->line("- moved_unique: $movedUnique");
        $this->line("- renamed_css_js: $renamedCssJs");
        $this->line("- deleted_same: $deletedSame");
        $this->line("- deleted_diff_media: $deletedDifferentMedia");
        $this->line("- skipped_exists: $skippedExists");
        $this->line("- errors: $errors");

        return $errors > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function sameFile(string $a, string $b): bool
    {
        return hash_file('sha256', $a) === hash_file('sha256', $b);
    }

    private function cleanupEmptyDirectories(string $root): void
    {
        $dirs = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                $dirs[] = $item->getPathname();
            }
        }

        foreach ($dirs as $dir) {
            if (! glob($dir.DIRECTORY_SEPARATOR.'*')) {
                @rmdir($dir);
            }
        }

        if (! glob($root.DIRECTORY_SEPARATOR.'*')) {
            @rmdir($root);
        }
    }
}
