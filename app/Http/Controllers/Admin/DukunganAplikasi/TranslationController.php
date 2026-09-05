<?php

namespace App\Http\Controllers\Admin\DukunganAplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DukunganAplikasi\TranslationRequest;
use App\Models\Admin\DukunganAplikasi\Menu;
use App\Traits\HasMenuPermission;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TranslationController extends Controller
{
    use HasNotification, HasMenuPermission;

    private string $idBasePath;
    private string $enBasePath;
    private string $idRootPath;
    private string $enRootPath;

    /**
     * Definisi 6 Domain Modul Kamus Modular
     */
    private array $modules = [
        'sidebar_menu' => [
            'name' => 'Sidebar: Menu Dinamis',
            'icon' => 'ti ti-menu-2',
            'badge' => 'bg-primary-subtle text-primary border-primary-subtle',
            'desc' => 'Menu dinamis database (tabel menus) via Seeder & GUI Menu'
        ],
        'sidebar_template' => [
            'name' => 'Sidebar: Template Bawaan',
            'icon' => 'ti ti-layout-sidebar',
            'badge' => 'bg-secondary-subtle text-secondary border-secondary-subtle',
            'desc' => 'Menu statis template dari config/sidenav-template/*.php'
        ],
        'topbar' => [
            'name' => 'Topbar & Navigasi Global',
            'icon' => 'ti ti-layout-navbar',
            'badge' => 'bg-info-subtle text-info border-info-subtle',
            'desc' => 'Header bilah atas, pencarian, notifikasi, dan profil'
        ],
        'auth' => [
            'name' => 'Autentikasi & Akun',
            'icon' => 'ti ti-lock',
            'badge' => 'bg-danger-subtle text-danger border-danger-subtle',
            'desc' => 'Formulir login, register, lock screen, reset password'
        ],
        'customizer' => [
            'name' => 'Admin Customizer',
            'icon' => 'ti ti-palette',
            'badge' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
            'desc' => 'Panel pengaturan tema, layout, warna, dan ukuran sidebar'
        ],
        'frontpage' => [
            'name' => 'Landing Page & Website',
            'icon' => 'ti ti-world',
            'badge' => 'bg-success-subtle text-success border-success-subtle',
            'desc' => 'Seksi halaman publik, landing page hero, fitur, dan footer'
        ],
    ];

    public function __construct()
    {
        $this->idBasePath = public_path('assets/data/translations/id');
        $this->enBasePath = public_path('assets/data/translations/en');
        $this->idRootPath = public_path('assets/data/translations/id.json');
        $this->enRootPath = public_path('assets/data/translations/en.json');

        if (!is_dir($this->idBasePath)) {
            @mkdir($this->idBasePath, 0777, true);
        }
        if (!is_dir($this->enBasePath)) {
            @mkdir($this->enBasePath, 0777, true);
        }
    }

    /**
     * Display a listing of modular translation dictionaries with Tab navigation.
     */
    public function index()
    {
        $activeModule = 'all';

        // 1. Auto-sync missing database menu keys to sidebar_menu.json
        $dbMenus = Menu::with('parent')->get();
        $idMenuData = $this->readModuleJson('id', 'sidebar_menu');
        $enMenuData = $this->readModuleJson('en', 'sidebar_menu');
        $menuUpdated = false;

        foreach ($dbMenus as $m) {
            $k = $m->data_lang ?: Str::slug($m->name);
            if (!empty($k)) {
                if (!isset($idMenuData[$k])) {
                    $idMenuData[$k] = $m->name;
                    $menuUpdated = true;
                }
                if (!isset($enMenuData[$k])) {
                    $enMenuData[$k] = Menu::getEnglishDefault($m->name);
                    $menuUpdated = true;
                }
            }
        }

        if ($menuUpdated) {
            $this->writeModuleJson('id', 'sidebar_menu', $idMenuData);
            $this->writeModuleJson('en', 'sidebar_menu', $enMenuData);
        }

        // 2. Load all modular translations
        $translations = [];
        $moduleCounts = ['all' => 0];
        $allMergedId = [];
        $allMergedEn = [];

        foreach (array_keys($this->modules) as $modKey) {
            $idMod = $this->readModuleJson('id', $modKey);
            $enMod = $this->readModuleJson('en', $modKey);

            $modKeys = array_unique(array_merge(array_keys($idMod), array_keys($enMod)));
            sort($modKeys);

            $moduleCounts[$modKey] = count($modKeys);
            $moduleCounts['all'] += count($modKeys);

            foreach ($modKeys as $k) {
                $tId = $idMod[$k] ?? '';
                $tEn = $enMod[$k] ?? '';

                $allMergedId[$k] = $tId;
                $allMergedEn[$k] = $tEn;

                $translations[] = [
                    'id' => count($translations) + 1,
                    'module' => $modKey,
                    'module_name' => $this->modules[$modKey]['name'],
                    'module_badge' => $this->modules[$modKey]['badge'],
                    'module_icon' => $this->modules[$modKey]['icon'],
                    'key' => $k,
                    'label' => $this->getHumanLabel($modKey, $k),
                    'text_id' => $tId,
                    'text_en' => $tEn,
                ];
            }
        }

        // 3. Sync merged root files for backward-compatibility
        $this->syncRootMergedFiles($allMergedId, $allMergedEn);

        $modules = $this->modules;

        return view('admin.dukunganaplikasi.translation', compact(
            'translations',
            'modules',
            'moduleCounts',
            'activeModule'
        ));
    }

    /**
     * Store a newly created translation key in modular JSON files.
     */
    public function store(TranslationRequest $request)
    {
        $module = $request->input('module', 'sidebar_menu');
        if (!array_key_exists($module, $this->modules)) {
            $module = 'sidebar_menu';
        }

        $key = trim($request->input('key'));
        $textId = trim($request->input('text_id'));
        $textEn = trim($request->input('text_en'));

        $idMod = $this->readModuleJson('id', $module);
        $enMod = $this->readModuleJson('en', $module);

        $idMod[$key] = $textId;
        $enMod[$key] = $textEn;

        $this->writeModuleJson('id', $module, $idMod);
        $this->writeModuleJson('en', $module, $enMod);

        $this->refreshRootMergedFiles();

        $this->notifySuccess("Key terjemahan \"{$key}\" berhasil ditambahkan pada modul " . $this->modules[$module]['name'] . ".");

        return redirect()->route('admin.dukunganaplikasi.translation.index');
    }

    /**
     * Update the specified translation key in modular JSON files.
     */
    public function update(TranslationRequest $request, string $translationKey)
    {
        $translationKey = urldecode($translationKey);
        $module = $request->input('module');

        // If module not provided, auto-detect where this key currently exists
        if (!$module || !array_key_exists($module, $this->modules)) {
            $module = $this->findKeyModule($translationKey) ?: 'sidebar_menu';
        }

        $newKey = trim($request->input('key'));
        $textId = trim($request->input('text_id'));
        $textEn = trim($request->input('text_en'));

        $idMod = $this->readModuleJson('id', $module);
        $enMod = $this->readModuleJson('en', $module);

        // If key was renamed, remove old key
        if ($translationKey !== $newKey) {
            unset($idMod[$translationKey], $enMod[$translationKey]);
        }

        $idMod[$newKey] = $textId;
        $enMod[$newKey] = $textEn;

        $this->writeModuleJson('id', $module, $idMod);
        $this->writeModuleJson('en', $module, $enMod);

        $this->refreshRootMergedFiles();

        $this->notifySuccess("Key terjemahan \"{$newKey}\" berhasil diperbarui pada modul " . $this->modules[$module]['name'] . ".");

        return redirect()->route('admin.dukunganaplikasi.translation.index');
    }

    /**
     * Remove the specified translation key from modular JSON files.
     */
    public function destroy(Request $request, string $translationKey)
    {
        $translationKey = urldecode($translationKey);
        $module = $request->input('module') ?: $this->findKeyModule($translationKey);

        if ($module && array_key_exists($module, $this->modules)) {
            $idMod = $this->readModuleJson('id', $module);
            $enMod = $this->readModuleJson('en', $module);

            unset($idMod[$translationKey], $enMod[$translationKey]);

            $this->writeModuleJson('id', $module, $idMod);
            $this->writeModuleJson('en', $module, $enMod);
        } else {
            // Remove across all modules if not specified
            foreach (array_keys($this->modules) as $mKey) {
                $idMod = $this->readModuleJson('id', $mKey);
                $enMod = $this->readModuleJson('en', $mKey);
                if (isset($idMod[$translationKey]) || isset($enMod[$translationKey])) {
                    unset($idMod[$translationKey], $enMod[$translationKey]);
                    $this->writeModuleJson('id', $mKey, $idMod);
                    $this->writeModuleJson('en', $mKey, $enMod);
                }
            }
        }

        $this->refreshRootMergedFiles();

        $this->notifySuccess("Key terjemahan \"{$translationKey}\" berhasil dihapus.");

        return redirect()->route('admin.dukunganaplikasi.translation.index');
    }

    /**
     * Helper to read a specific modular JSON file.
     */
    private function readModuleJson(string $lang, string $module): array
    {
        $path = public_path("assets/data/translations/{$lang}/{$module}.json");
        if (!file_exists($path)) {
            return [];
        }
        $content = @file_get_contents($path);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    /**
     * Helper to write a specific modular JSON file cleanly.
     */
    private function writeModuleJson(string $lang, string $module, array $data): void
    {
        $dir = public_path("assets/data/translations/{$lang}");
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        ksort($data);
        $path = "{$dir}/{$module}.json";
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($path, $json);
    }

    /**
     * Find which module contains the specified key.
     */
    private function findKeyModule(string $key): ?string
    {
        foreach (array_keys($this->modules) as $modKey) {
            $data = $this->readModuleJson('id', $modKey);
            if (isset($data[$key])) {
                return $modKey;
            }
        }
        return null;
    }

    /**
     * Helper to re-generate merged root id.json and en.json.
     */
    private function refreshRootMergedFiles(): void
    {
        $mergedId = [];
        $mergedEn = [];

        foreach (array_keys($this->modules) as $modKey) {
            $idMod = $this->readModuleJson('id', $modKey);
            $enMod = $this->readModuleJson('en', $modKey);
            $mergedId = array_merge($mergedId, $idMod);
            $mergedEn = array_merge($mergedEn, $enMod);
        }

        $this->syncRootMergedFiles($mergedId, $mergedEn);
    }

    /**
     * Write merged array to root id.json and en.json.
     */
    private function syncRootMergedFiles(array $idData, array $enData): void
    {
        ksort($idData);
        ksort($enData);

        file_put_contents($this->idRootPath, json_encode($idData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        file_put_contents($this->enRootPath, json_encode($enData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Helper to construct human-readable position/category label for a key.
     */
    private function getHumanLabel(string $module, string $key): string
    {
        return match ($module) {
            'sidebar_menu' => 'Menu Dinamis App',
            'sidebar_template' => 'Item Template Bawaan',
            'topbar' => 'Topbar & Navigasi',
            'auth' => 'Otentikasi & Akun',
            'customizer' => 'Theme Customizer',
            'frontpage' => 'Landing Page / Publik',
            default => 'Label Sistem'
        };
    }
}
