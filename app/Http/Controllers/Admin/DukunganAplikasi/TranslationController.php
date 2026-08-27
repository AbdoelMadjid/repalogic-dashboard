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

    private string $idJsonPath;
    private string $enJsonPath;

    public function __construct()
    {
        $this->idJsonPath = public_path('assets/data/translations/id.json');
        $this->enJsonPath = public_path('assets/data/translations/en.json');
    }

    /**
     * Display a listing of translation keys & values grouped by Sidebar Menu & Labels.
     */
    public function index(Request $request)
    {
        $idData = $this->readJson($this->idJsonPath);
        $enData = $this->readJson($this->enJsonPath);

        $allKeys = array_unique(array_merge(array_keys($idData), array_keys($enData)));
        sort($allKeys);

        // Map Database Menus
        $dbMenus = Menu::with('parent')->get();
        $dbKeyMap = [];

        foreach ($dbMenus as $m) {
            $k = $m->data_lang ?: Str::slug($m->name);
            $catName = $m->category ? strtoupper($m->category) : 'MASTER DATA';
            $typeLabel = $m->main_menu_id ? 'Sub-Menu: ' . $m->name : 'Menu Utama: ' . $m->name;
            $dbKeyMap[$k] = [
                'group' => "Database Menu ({$catName})",
                'label' => $typeLabel
            ];

            if ($m->category) {
                $cKey = Str::slug($m->category);
                if (!isset($dbKeyMap[$cKey])) {
                    $dbKeyMap[$cKey] = [
                        'group' => "Database Menu ({$catName})",
                        'label' => "Group Header: {$catName}"
                    ];
                }
            }
        }

        // Map Template Config Menus
        $templateKeyMap = [];
        $templateFiles = glob(config_path('sidenav-template/*.php'));
        foreach ($templateFiles as $tf) {
            $cfg = include $tf;
            $gTitle = $cfg['title'] ?? basename($tf, '.php');
            if (isset($cfg['data_lang'])) {
                $templateKeyMap[$cfg['data_lang']] = [
                    'group' => "Template Menu ({$gTitle})",
                    'label' => "Group Header: {$gTitle}"
                ];
            }
            $mapItems = function($items) use (&$mapItems, $gTitle, &$templateKeyMap) {
                foreach ($items as $it) {
                    if (isset($it['data_lang'])) {
                        $templateKeyMap[$it['data_lang']] = [
                            'group' => "Template Menu ({$gTitle})",
                            'label' => "Menu Item: " . ($it['title'] ?? '')
                        ];
                    }
                    if (!empty($it['children'])) {
                        $mapItems($it['children']);
                    }
                }
            };
            if (!empty($cfg['items'])) {
                $mapItems($cfg['items']);
            }
        }

        $translations = [];
        $categoriesList = [];

        foreach ($allKeys as $index => $k) {
            if (isset($dbKeyMap[$k])) {
                $groupName = $dbKeyMap[$k]['group'];
                $label = $dbKeyMap[$k]['label'];
            } elseif (isset($templateKeyMap[$k])) {
                $groupName = $templateKeyMap[$k]['group'];
                $label = $templateKeyMap[$k]['label'];
            } else {
                $groupName = 'Komponen & Label Umum';
                $label = 'Label Sistem';
            }

            $categoriesList[$groupName] = true;

            $translations[] = [
                'id' => $index + 1,
                'key' => $k,
                'group' => $groupName,
                'label' => $label,
                'text_id' => $idData[$k] ?? '',
                'text_en' => $enData[$k] ?? '',
            ];
        }

        $categories = array_keys($categoriesList);
        sort($categories);

        // Group translations by groupName
        $groupedTranslations = [];
        foreach ($translations as $item) {
            $groupedTranslations[$item['group']][] = $item;
        }

        return view('admin.dukunganaplikasi.translation.index', compact('translations', 'groupedTranslations', 'categories'));
    }

    /**
     * Store a newly created translation key in JSON files.
     */
    public function store(TranslationRequest $request)
    {
        $key = trim($request->input('key'));
        $textId = trim($request->input('text_id'));
        $textEn = trim($request->input('text_en'));

        $idData = $this->readJson($this->idJsonPath);
        $enData = $this->readJson($this->enJsonPath);

        $idData[$key] = $textId;
        $enData[$key] = $textEn;

        $this->writeJson($this->idJsonPath, $idData);
        $this->writeJson($this->enJsonPath, $enData);

        $this->notifySuccess("Key terjemahan \"{$key}\" berhasil ditambahkan.");

        return redirect()->route('admin.dukunganaplikasi.translation.index');
    }

    /**
     * Update the specified translation key in JSON files.
     */
    public function update(TranslationRequest $request, string $translationKey)
    {
        $translationKey = urldecode($translationKey);
        $newKey = trim($request->input('key'));
        $textId = trim($request->input('text_id'));
        $textEn = trim($request->input('text_en'));

        $idData = $this->readJson($this->idJsonPath);
        $enData = $this->readJson($this->enJsonPath);

        // If key was renamed, remove old key
        if ($translationKey !== $newKey) {
            unset($idData[$translationKey], $enData[$translationKey]);
        }

        $idData[$newKey] = $textId;
        $enData[$newKey] = $textEn;

        $this->writeJson($this->idJsonPath, $idData);
        $this->writeJson($this->enJsonPath, $enData);

        $this->notifySuccess("Key terjemahan \"{$newKey}\" berhasil diperbarui.");

        return redirect()->route('admin.dukunganaplikasi.translation.index');
    }

    /**
     * Remove the specified translation key from JSON files.
     */
    public function destroy(string $translationKey)
    {
        $translationKey = urldecode($translationKey);

        $idData = $this->readJson($this->idJsonPath);
        $enData = $this->readJson($this->enJsonPath);

        unset($idData[$translationKey], $enData[$translationKey]);

        $this->writeJson($this->idJsonPath, $idData);
        $this->writeJson($this->enJsonPath, $enData);

        $this->notifySuccess("Key terjemahan \"{$translationKey}\" berhasil dihapus.");

        return redirect()->route('admin.dukunganaplikasi.translation.index');
    }

    /**
     * Helper to read JSON file securely.
     */
    private function readJson(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        $data = json_decode($content, true);

        return is_array($data) ? $data : [];
    }

    /**
     * Helper to write JSON file formatted cleanly.
     */
    private function writeJson(string $path, array $data): void
    {
        ksort($data);
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($path, $json);
    }
}
