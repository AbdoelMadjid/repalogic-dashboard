<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MenuSync extends Command
{
    protected $signature = 'menu:sync
        {--path=unify/unify-main/pages : Folder di resources/views}
        {--output=menu_pages.php : Nama file output}';

    protected $description = 'Sync menu_pages config dari struktur folder pages (recursive & manual-style Unify)';

    private function exportArrayShort(array $array, int $indent = 0): string
    {
        $space = str_repeat('    ', $indent);
        $out = "[\n";

        foreach ($array as $key => $value) {
            $out .= $space . '    ';
            if (!is_int($key)) {
                $out .= "'{$key}' => ";
            }

            if (is_array($value)) {
                $out .= $this->exportArrayShort($value, $indent + 1);
            } else {
                $out .= var_export($value, true);
            }

            $out .= ",\n";
        }

        return $out . $space . ']';
    }

    public function handle()
    {
        $scanPath = trim($this->option('path'), '/');
        $basePath = resource_path('views/' . $scanPath);

        if (!File::exists($basePath)) {
            $this->error("❌ Folder tidak ditemukan: {$basePath}");
            return Command::FAILURE;
        }

        $tree = [];

        $files = collect(File::allFiles($basePath))
            ->filter(fn($f) => str_ends_with($f->getFilename(), '.blade.php'))
            ->sortBy(fn($f) => $f->getPathname());

        foreach ($files as $file) {

            $relative = str_replace(
                [$basePath . DIRECTORY_SEPARATOR, '.blade.php'],
                '',
                $file->getPathname()
            );

            $segments = explode(DIRECTORY_SEPARATOR, $relative);
            $fileName = array_pop($segments);

            if ($fileName === 'index' && empty($segments)) {
                continue;
            }

            $current = &$tree;

            // folder → submenu (recursive)
            foreach ($segments as $segment) {

                if (!isset($current[$segment])) {
                    $current[$segment] = [
                        'label'   => Str::of($segment)->replace('-', ' ')->title()->toString(),
                        'route'   => null,
                        'submenu' => [],
                    ];
                }

                $current = &$current[$segment]['submenu'];
            }

            // file → menu item
            $route = 'template.' . Str::of(
                $scanPath . '/' . implode('/', $segments) . '/' . $fileName
            )
                ->replace('//', '/')
                ->replace('/', '.')
                ->replace('-', '')
                ->lower()
                ->toString();

            $current[] = [
                'label' => Str::of($fileName)->replace('-', ' ')->title()->toString(),
                'route' => $route,
            ];
        }

        $outputFile = basename($this->option('output'), '.php');
        // menu_pages.php → menu_pages
        $configKey = $outputFile;

        $path = trim($this->option('path'), '/');
        $segments = explode('/', $path);
        $labelRaw = end($segments);

        // pages → Pages
        // home  → Home
        $label = Str::headline($labelRaw);

        $output = [
            $configKey => [
                [
                    'label'   => $label,
                    'route'   => null,
                    'icon'    => null,
                    'submenu' => array_values($tree),
                ],
            ],
        ];

        $filePath = config_path($this->option('output'));

        File::put(
            $filePath,
            "<?php\n\nreturn " . $this->exportArrayShort($output) . ";\n"
        );

        $this->info('✅ menu_pages berhasil disinkronkan');
        $this->line("📄 {$filePath}");

        return Command::SUCCESS;
    }
}
