<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MenuLangSync extends Command
{
    protected $signature = 'menu:lang-sync
        {--scan=app,config,resources,routes,database : Direktori yang dipindai (comma-separated)}
        {--prune=1 : Hapus key menu lama yang tidak terpakai (1/0)}
        {--dry-run : Tampilkan hasil tanpa menulis file}';

    protected $description = 'Sinkronisasi key bilingual menu (lang/id/menu.php & lang/en/menu.php) berdasarkan pemakaian @lang/__ di project dan config menu.';

    public function handle(): int
    {
        $scanDirs = $this->parseCsvOption((string) $this->option('scan'));
        $prune = (string) $this->option('prune') !== '0';
        $dryRun = (bool) $this->option('dry-run');

        $usedKeys = $this->collectUsedMenuKeys($scanDirs);
        sort($usedKeys);

        if (empty($usedKeys)) {
            $this->warn('Tidak ada key menu.* yang terdeteksi.');
            return self::SUCCESS;
        }

        $idPath = lang_path('id/menu.php');
        $enPath = lang_path('en/menu.php');

        $idExisting = $this->loadLangArray($idPath);
        $enExisting = $this->loadLangArray($enPath);

        if ($idExisting === null || $enExisting === null) {
            $this->error('Gagal memuat file translasi menu.php.');
            return self::FAILURE;
        }

        $idSynced = $this->buildSyncedArray($usedKeys, $idExisting, $enExisting, $prune);
        $enSynced = $this->buildSyncedArray($usedKeys, $enExisting, $idExisting, $prune);

        $idChanges = $this->countChanges($idExisting, $idSynced);
        $enChanges = $this->countChanges($enExisting, $enSynced);

        $this->line("Total key terpakai: " . count($usedKeys));
        $this->line("ID  -> tambah: {$idChanges['added']}, ubah: {$idChanges['updated']}, hapus: {$idChanges['removed']}");
        $this->line("EN  -> tambah: {$enChanges['added']}, ubah: {$enChanges['updated']}, hapus: {$enChanges['removed']}");

        if ($dryRun) {
            $this->info('Dry run selesai. Tidak ada file yang diubah.');
            return self::SUCCESS;
        }

        $this->writeLangArray($idPath, $idSynced);
        $this->writeLangArray($enPath, $enSynced);

        $this->info('Sinkronisasi selesai.');
        $this->line("File: {$idPath}");
        $this->line("File: {$enPath}");

        return self::SUCCESS;
    }

    private function collectUsedMenuKeys(array $scanDirs): array
    {
        $keys = [];

        foreach ($scanDirs as $dir) {
            $fullDir = base_path($dir);
            if (!File::isDirectory($fullDir)) {
                continue;
            }

            foreach (File::allFiles($fullDir) as $file) {
                $path = $file->getPathname();
                $relative = str_replace('\\', '/', $file->getRelativePathname());

                if ($this->shouldSkipFile($relative)) {
                    continue;
                }

                $content = File::get($path);
                foreach ($this->extractMenuKeysFromContent($content) as $key) {
                    $keys[$key] = true;
                }

                if (str_starts_with(str_replace('\\', '/', $path), str_replace('\\', '/', config_path()))) {
                    foreach ($this->extractTitleKeysFromContent($content) as $key) {
                        $keys[$key] = true;
                    }
                }
            }
        }

        foreach ($this->collectMenuSeederDerivedKeys() as $key) {
            $keys[$key] = true;
        }

        return array_keys($keys);
    }

    private function parseCsvOption(string $value): array
    {
        return array_values(array_filter(array_map(
            fn($v) => trim($v),
            explode(',', $value)
        )));
    }

    private function shouldSkipFile(string $relativePath): bool
    {
        $normalized = str_replace('\\', '/', $relativePath);

        if (str_contains($normalized, '/vendor/') || str_contains($normalized, '/node_modules/')) {
            return true;
        }

        return false;
    }

    private function extractMenuKeysFromContent(string $content): array
    {
        $keys = [];

        $patterns = [
            '/@lang\(\s*[\'"]menu\.([^\'"]+)[\'"]\s*\)/',
            '/__\(\s*[\'"]menu\.([^\'"]+)[\'"]/',
            '/trans\(\s*[\'"]menu\.([^\'"]+)[\'"]\s*\)/',
            '/Lang::get\(\s*[\'"]menu\.([^\'"]+)[\'"]\s*\)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $content, $matches) !== false) {
                foreach ($matches[1] ?? [] as $key) {
                    $keys[(string) $key] = true;
                }
            }
        }

        return array_keys($keys);
    }

    private function extractTitleKeysFromContent(string $content): array
    {
        $keys = [];

        if (preg_match_all('/[\'"]title_key[\'"]\s*=>\s*[\'"]([^\'"]+)[\'"]/', $content, $matches) !== false) {
            foreach ($matches[1] ?? [] as $match) {
                $keys[(string) $match] = true;
            }
        }

        if (preg_match_all('/[\'"]title[\'"]\s*=>\s*[\'"]([^\'"]+)[\'"]/', $content, $matches) !== false) {
            foreach ($matches[1] ?? [] as $title) {
                $slug = $this->titleToKey((string) $title);
                if ($slug !== '') {
                    $keys[$slug] = true;
                }
            }
        }

        return array_keys($keys);
    }

    private function collectMenuSeederDerivedKeys(): array
    {
        $keys = [];

        $categories = config('menu_seeder.categories', []);
        foreach ($categories as $category => $config) {
            $categoryKey = Str::of((string) $category)->lower()->replace(' ', '_')->toString();
            if ($categoryKey !== '') {
                $keys[$categoryKey] = true;
            }

            foreach ($this->collectTitleKeysRecursively((array) ($config['menus'] ?? [])) as $titleKey) {
                $keys[$titleKey] = true;
            }
        }

        return array_keys($keys);
    }

    private function collectTitleKeysRecursively(array $items): array
    {
        $keys = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            if (!empty($item['title_key']) && is_string($item['title_key'])) {
                $keys[$item['title_key']] = true;
            }

            if (!empty($item['title']) && is_string($item['title'])) {
                $derived = $this->titleToKey($item['title']);
                if ($derived !== '') {
                    $keys[$derived] = true;
                }
            }

            foreach (['children', 'children_collapsed'] as $nestedKey) {
                if (!empty($item[$nestedKey]) && is_array($item[$nestedKey])) {
                    foreach ($this->collectTitleKeysRecursively($item[$nestedKey]) as $childKey) {
                        $keys[$childKey] = true;
                    }
                }
            }
        }

        return array_keys($keys);
    }

    private function titleToKey(string $title): string
    {
        return strtolower(str_replace([' ', '&', '/'], ['_', 'and', '_'], trim($title)));
    }

    private function loadLangArray(string $path): ?array
    {
        if (!File::exists($path)) {
            return null;
        }

        $loaded = include $path;
        if (!is_array($loaded)) {
            return null;
        }

        return $loaded;
    }

    private function buildSyncedArray(array $usedKeys, array $primary, array $secondary, bool $prune): array
    {
        $result = [];

        foreach ($usedKeys as $key) {
            if (array_key_exists($key, $primary)) {
                $result[$key] = (string) $primary[$key];
                continue;
            }

            if (array_key_exists($key, $secondary)) {
                $result[$key] = (string) $secondary[$key];
                continue;
            }

            $result[$key] = Str::headline(str_replace(['_', '-'], ' ', $key));
        }

        if (!$prune) {
            foreach ($primary as $key => $value) {
                if (!array_key_exists($key, $result)) {
                    $result[$key] = (string) $value;
                }
            }
        }

        ksort($result);

        return $result;
    }

    private function countChanges(array $before, array $after): array
    {
        $beforeKeys = array_keys($before);
        $afterKeys = array_keys($after);

        $added = count(array_diff($afterKeys, $beforeKeys));
        $removed = count(array_diff($beforeKeys, $afterKeys));

        $updated = 0;
        foreach (array_intersect($beforeKeys, $afterKeys) as $key) {
            if ((string) $before[$key] !== (string) $after[$key]) {
                $updated++;
            }
        }

        return [
            'added' => $added,
            'removed' => $removed,
            'updated' => $updated,
        ];
    }

    private function writeLangArray(string $path, array $data): void
    {
        $content = "<?php\n\nreturn " . var_export($data, true) . ";\n";
        File::put($path, $content);
    }
}
