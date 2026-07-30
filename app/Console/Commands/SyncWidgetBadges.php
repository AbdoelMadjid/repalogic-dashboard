<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncWidgetBadges extends Command
{
    protected $signature = 'widgets:sync-badges {--dry-run : Show changes without writing files}';

    protected $description = 'Sync dashboard widget-include-badge from all partials/widgets categories + pages/widgets references';

    public function handle(): int
    {
        $meta = $this->buildWidgetCatalog();
        if (empty($meta)) {
            $this->warn('No widget metadata found under resources/views/partials/widgets.');

            return self::SUCCESS;
        }

        $knownTypes = array_keys($meta);

        $dashboardFiles = File::files(resource_path('views/pages/dashboards'));
        $changes = 0;

        foreach ($dashboardFiles as $file) {
            $path = $file->getPathname();
            $lines = file($path, FILE_IGNORE_NEW_LINES);
            if ($lines === false) {
                continue;
            }

            $updated = $lines;
            $fileChanged = false;
            $ctxType = null;
            $ctxNum = null;

            foreach ($updated as $i => $line) {
                if (preg_match('/begin::([A-Za-z]+)\\s+[Ww]idget\\s+([A-Za-z0-9]+)/', $line, $m)) {
                    $ctxType = $this->normalizeTypeToken($m[1], $knownTypes);
                    $ctxNum = $m[2];
                    continue;
                }

                if (!preg_match('/^(\\s*)<x-widget-include-badge\\s+name=(["\'])([a-z0-9]+)\\.__widget-([^"\']+)\\2([^>]*)\\/>\\s*$/i', $line, $m)) {
                    continue;
                }

                $indent = $m[1];
                $type = strtolower($m[3]);
                if (!isset($meta[$type])) {
                    $ctxType = null;
                    $ctxNum = null;
                    continue;
                }

                $raw = trim($m[4]);
                $currentId = $this->stripFollow($raw);

                $targetId = $currentId;
                $includeRef = $this->findIncludeRefNearBadge($updated, $i, $meta);
                if ($includeRef !== null) {
                    $type = $includeRef['type'];
                    $targetId = $includeRef['id'];
                }

                if ($ctxType === $type && $ctxNum !== null) {
                    $bySection = $meta[$type]['bySection'][$ctxNum] ?? [];
                    if (count($bySection) === 1) {
                        $targetId = $bySection[0];
                    }
                }

                if (!isset($meta[$type]['badgeById'][$targetId])) {
                    $ctxType = null;
                    $ctxNum = null;
                    continue;
                }

                $expectedName = $meta[$type]['badgeById'][$targetId];
                $isFollow = ($meta[$type]['followById'][$targetId] ?? null) !== null;
                $expectedFlex = !$isFollow && ($meta[$type]['flexById'][$targetId] ?? false);

                $newLine = $indent . '<x-widget-include-badge name="' . $expectedName . '"' . ($expectedFlex ? ' flexible' : '') . ' />';

                if ($newLine !== $line) {
                    $updated[$i] = $newLine;
                    $fileChanged = true;
                    $changes++;
                }

                $ctxType = null;
                $ctxNum = null;
            }

            if ($fileChanged && !$this->option('dry-run')) {
                File::put($path, implode(PHP_EOL, $updated) . PHP_EOL);
            }

            if ($fileChanged) {
                $this->line(($this->option('dry-run') ? '[dry-run] ' : '') . 'updated: ' . $path);
            }
        }

        $this->info('Total badge changes: ' . $changes);

        return self::SUCCESS;
    }

    private function buildWidgetCatalog(): array
    {
        $root = resource_path('views/partials/widgets');
        if (!File::exists($root)) {
            return [];
        }

        $catalog = [];
        $folders = File::directories($root);
        foreach ($folders as $folderPath) {
            $folder = basename($folderPath);
            $pageRef = resource_path("views/pages/pages/widgets/{$folder}.blade.php");
            $type = $this->detectTypeForFolder($folder, $pageRef);

            $meta = $this->buildTypeMeta($type, $folder, $pageRef);
            if (empty($meta['badgeById'])) {
                continue;
            }

            $meta['folder'] = $folder;
            $catalog[$type] = $meta;
        }

        return $catalog;
    }

    private function buildTypeMeta(string $type, string $folder, string $pageRef): array
    {
        $widgetDir = resource_path("views/partials/widgets/{$folder}");
        if (!File::exists($widgetDir)) {
            return [
                'badgeById' => [],
                'flexById' => [],
                'bySection' => [],
            ];
        }

        $badgeById = [];
        $flexById = $this->readFlexibleMapFromShowcase($type, $pageRef);
        $bySection = [];
        $followById = [];

        foreach (File::files($widgetDir) as $file) {
            $name = $file->getFilename();
            if (!preg_match('/^_widget-([A-Za-z0-9]+)\\.blade\\.php$/', $name, $nm)) {
                continue;
            }

            $id = $nm[1];
            $content = file_get_contents($file->getPathname()) ?: '';
            $follow = $this->detectFollowId($content, $folder);
            $followById[$id] = $follow;

            $badgeById[$id] = $type . '.__widget-' . $id . ($follow ? ' (follow __widget-' . $follow . ')' : '');

            if (preg_match('/begin::[A-Za-z]+\\s+[Ww]idget\\s+([A-Za-z0-9]+)/', $content, $sm)) {
                $section = $sm[1];
                $bySection[$section] = $bySection[$section] ?? [];
                $bySection[$section][] = $id;
            }
        }

        return [
            'badgeById' => $badgeById,
            'flexById' => $flexById,
            'bySection' => $bySection,
            'followById' => $followById,
        ];
    }

    private function detectTypeForFolder(string $folder, string $pageRef): string
    {
        if (File::exists($pageRef)) {
            $content = file_get_contents($pageRef) ?: '';
            if (preg_match('/x-widget-include-badge\\s+name=["\']([a-z0-9]+)\\.__widget-/i', $content, $m)) {
                return strtolower($m[1]);
            }
        }

        return $this->singularizeFolder($folder);
    }

    private function readFlexibleMapFromShowcase(string $type, string $path): array
    {
        $map = [];
        if (!File::exists($path)) {
            return $map;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES) ?: [];
        $typePattern = preg_quote($type, '/');
        foreach ($lines as $rawLine) {
            $line = trim($rawLine);

            if (preg_match('/x-widget-include-badge\\s+name=["\']' . $typePattern . '\\.__widget-([^"\']+)["\']([^>]*)\\/>/i', $line, $m)) {
                $id = $this->stripFollow(trim($m[1]));
                $attrs = strtolower($m[2] ?? '');
                $isFlexible = str_contains($attrs, 'flexible');
                if ($isFlexible || !array_key_exists($id, $map)) {
                    $map[$id] = $isFlexible;
                }
                continue;
            }

            if (preg_match('/\'badge\'\\s*=>\\s*\'' . $typePattern . '\\.__widget-([^\']+)\'(.*)/i', $line, $m)) {
                $id = $this->stripFollow(trim($m[1]));
                $isFlexible = preg_match('/\'flexible\'\\s*=>\\s*true/i', $m[2]) === 1;
                if ($isFlexible || !array_key_exists($id, $map)) {
                    $map[$id] = $isFlexible;
                }
            }
        }

        return $map;
    }

    private function detectFollowId(string $content, string $folder): ?string
    {
        $lines = preg_split('/\\R/', $content) ?: [];
        $probe = array_slice($lines, 0, 20);
        $head = implode("\n", $probe);
        $includePattern = "/@include\\('partials\\.widgets\\." . preg_quote($folder, '/') . "\\._widget-([A-Za-z0-9]+)'/";

        if (preg_match($includePattern, $head, $m)) {
            return $m[1];
        }

        return null;
    }

    private function normalizeTypeToken(string $token, array $knownTypes): ?string
    {
        $candidate = strtolower($token);
        if (in_array($candidate, $knownTypes, true)) {
            return $candidate;
        }

        $singular = rtrim($candidate, 's');
        if (in_array($singular, $knownTypes, true)) {
            return $singular;
        }

        $plural = $candidate . 's';
        if (in_array($plural, $knownTypes, true)) {
            return $plural;
        }

        return null;
    }

    private function singularizeFolder(string $folder): string
    {
        $folder = strtolower($folder);
        if (str_ends_with($folder, 'ies')) {
            return substr($folder, 0, -3) . 'y';
        }

        if (str_ends_with($folder, 's')) {
            return substr($folder, 0, -1);
        }

        return $folder;
    }

    private function stripFollow(string $raw): string
    {
        if (preg_match('/^([A-Za-z0-9]+)\\s+\\(follow\\s+__widget-[A-Za-z0-9]+\\)$/', $raw, $m)) {
            return $m[1];
        }

        return $raw;
    }

    private function findIncludeRefNearBadge(array $lines, int $badgeIndex, array $meta): ?array
    {
        $folderToType = [];
        foreach ($meta as $type => $data) {
            $folder = $data['folder'] ?? null;
            if ($folder) {
                $folderToType[$folder] = $type;
            }
        }

        if (empty($folderToType)) {
            return null;
        }

        $from = $badgeIndex + 1;
        $to = min(count($lines) - 1, $badgeIndex + 20);

        for ($i = $from; $i <= $to; $i++) {
            $line = $lines[$i];
            if (preg_match('/<x-widget-include-badge\\s+name=/i', $line)) {
                // Stop at next badge to avoid stealing previous/next widget context.
                break;
            }
            if (!preg_match("/@include\\('partials\\.widgets\\.([a-z]+)\\._widget-([A-Za-z0-9]+)'/", $line, $m)) {
                continue;
            }

            $folder = strtolower($m[1]);
            $id = $m[2];
            $type = $folderToType[$folder] ?? null;
            if (!$type || !isset($meta[$type]['badgeById'][$id])) {
                continue;
            }

            return [
                'type' => $type,
                'id' => $id,
            ];
        }

        return null;
    }
}
