<?php

namespace App\Http\Controllers\Admin\DukunganAplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DukunganAplikasi\KonfigurasiWebsiteRequest;
use App\Models\Admin\DukunganAplikasi\WebsiteSection;
use App\Models\Admin\DukunganAplikasi\WebsiteTheme;
use App\Traits\HasMenuPermission;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KonfigurasiWebsiteController extends Controller
{
    use HasNotification, HasMenuPermission;

    /**
     * Display website configuration management page.
     */
    public function index(Request $request)
    {
        $themes = WebsiteTheme::with('sections')->get();
        
        $selectedThemeId = $request->query('theme_id');
        if ($selectedThemeId) {
            $activeTheme = WebsiteTheme::with('sections')->find($selectedThemeId);
        } else {
            $activeTheme = WebsiteTheme::where('is_active', true)->with('sections')->first();
        }

        if (!$activeTheme && $themes->isNotEmpty()) {
            $activeTheme = $themes->first();
        }

        return view('admin.dukunganaplikasi.konfigurasi-website', compact('themes', 'activeTheme'));
    }

    /**
     * Store new or update theme.
     */
    public function storeTheme(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'folder' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $themeId = $request->input('theme_id');
        $slug = Str::slug($request->input('name'));

        if ($themeId) {
            $theme = WebsiteTheme::findOrFail($themeId);
            $theme->update([
                'name' => $request->input('name'),
                'slug' => $slug,
                'folder' => Str::slug($request->input('folder')),
                'description' => $request->input('description'),
            ]);
            $this->notifySuccess("Tema \"{$theme->name}\" berhasil diperbarui.");
        } else {
            $theme = WebsiteTheme::create([
                'name' => $request->input('name'),
                'slug' => $slug,
                'folder' => Str::slug($request->input('folder')),
                'description' => $request->input('description'),
                'is_active' => WebsiteTheme::count() === 0,
            ]);
            $this->notifySuccess("Tema baru \"{$theme->name}\" berhasil ditambahkan.");
        }

        WebsiteTheme::clearCache();

        return redirect()->route('admin.dukunganaplikasi.konfigurasi-website.index', ['theme_id' => $theme->id]);
    }

    /**
     * Activate a theme.
     */
    public function activateTheme($id)
    {
        $theme = WebsiteTheme::findOrFail($id);

        WebsiteTheme::query()->update(['is_active' => false]);
        $theme->update(['is_active' => true]);

        WebsiteTheme::clearCache();

        $this->notifySuccess("Tema \"{$theme->name}\" berhasil diaktifkan untuk Tampilan Website Utama!");

        return redirect()->route('admin.dukunganaplikasi.konfigurasi-website.index', ['theme_id' => $theme->id]);
    }

    /**
     * Store new section for a theme.
     */
    public function storeSection(Request $request)
    {
        $request->validate([
            'website_theme_id' => 'required|exists:website_themes,id',
            'section_name' => 'required|string|max:255',
            'section_file' => 'required|string|max:255',
            'nav_title' => 'nullable|string|max:100',
            'target_id' => 'nullable|string|max:100',
            'orders' => 'nullable|integer',
            'bg_type' => 'nullable|string|max:50',
            'bg_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $themeId = $request->input('website_theme_id');
        $sectionName = $request->input('section_name');
        $sectionKey = Str::slug($sectionName);

        $maxOrders = WebsiteSection::where('website_theme_id', $themeId)->max('orders') ?? 0;

        $file = trim($request->input('section_file'));
        if (!Str::endsWith($file, '.blade.php')) {
            $file .= '.blade.php';
        }

        $targetId = trim($request->input('target_id'));
        if (empty($targetId)) {
            $targetId = Str::slug($request->input('nav_title') ?: $sectionKey);
        }

        $bgImage = null;
        $imgW = null;
        $imgH = null;
        $imgOrient = null;

        if ($request->hasFile('bg_image_file')) {
            $fileObj = $request->file('bg_image_file');
            list($imgW, $imgH, $imgOrient) = $this->getImageMeta($fileObj);
            $bgImage = $fileObj->store('sections', 'public');
        }

        $bgColorClasses = [
            'light'     => 'bg-light bg-opacity-30 border-top border-bottom border-light',
            'secondary' => 'bg-body-secondary border-top border-bottom',
            'dark'      => 'bg-dark text-white',
            'primary'   => 'bg-primary text-white',
            'image'     => 'website-section-bg-image text-white',
            'default'   => null,
        ];

        $bgType = $request->input('bg_type', 'default');
        $bgColorClass = $bgColorClasses[$bgType] ?? $request->input('bg_color_class');

        WebsiteSection::create([
            'website_theme_id' => $themeId,
            'section_name' => $sectionName,
            'section_key' => $sectionKey,
            'section_file' => $file,
            'nav_title' => $request->input('nav_title'),
            'target_id' => $targetId,
            'show_in_nav' => $request->has('show_in_nav'),
            'is_active' => $request->has('is_active'),
            'orders' => $request->input('orders', $maxOrders + 1),
            'bg_type' => $bgType,
            'bg_color_class' => $bgColorClass,
            'bg_image' => $bgImage,
            'bg_position_y' => $request->input('bg_position_y', 50),
            'bg_size' => $request->input('bg_size', 'cover'),
            'bg_attachment' => $request->input('bg_attachment', 'scroll'),
            'bg_image_width' => $imgW,
            'bg_image_height' => $imgH,
            'bg_image_orientation' => $imgOrient,
        ]);

        WebsiteTheme::clearCache();

        $this->notifySuccess("Seksi halaman \"{$sectionName}\" berhasil ditambahkan.");

        return redirect()->route('admin.dukunganaplikasi.konfigurasi-website.index', ['theme_id' => $themeId]);
    }

    /**
     * Update existing section.
     */
    public function updateSection(Request $request, $id)
    {
        $section = WebsiteSection::findOrFail($id);

        $request->validate([
            'section_name' => 'required|string|max:255',
            'section_file' => 'required|string|max:255',
            'nav_title' => 'nullable|string|max:100',
            'target_id' => 'nullable|string|max:100',
            'orders' => 'nullable|integer',
            'bg_type' => 'nullable|string|max:50',
            'bg_position_y' => 'nullable|integer|min:0|max:100',
            'bg_size' => 'nullable|string|max:50',
            'bg_attachment' => 'nullable|string|max:50',
            'bg_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $file = trim($request->input('section_file'));
        if (!Str::endsWith($file, '.blade.php')) {
            $file .= '.blade.php';
        }

        $targetId = trim($request->input('target_id'));
        if (empty($targetId)) {
            $targetId = Str::slug($request->input('nav_title') ?: $section->section_key);
        }

        $bgImage = $section->bg_image;
        $imgW = $section->bg_image_width;
        $imgH = $section->bg_image_height;
        $imgOrient = $section->bg_image_orientation;

        if ($request->hasFile('bg_image_file')) {
            if ($bgImage && \Illuminate\Support\Facades\Storage::disk('public')->exists($bgImage)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($bgImage);
            }
            $fileObj = $request->file('bg_image_file');
            list($imgW, $imgH, $imgOrient) = $this->getImageMeta($fileObj);
            $bgImage = $fileObj->store('sections', 'public');
        }

        $bgColorClasses = [
            'light'     => 'bg-light bg-opacity-30 border-top border-bottom border-light',
            'secondary' => 'bg-body-secondary border-top border-bottom',
            'dark'      => 'bg-dark text-white',
            'primary'   => 'bg-primary text-white',
            'image'     => 'website-section-bg-image text-white',
            'default'   => null,
        ];

        $bgType = $request->input('bg_type', 'default');
        $bgColorClass = $bgColorClasses[$bgType] ?? $request->input('bg_color_class');

        $section->update([
            'section_name' => $request->input('section_name'),
            'section_file' => $file,
            'nav_title' => $request->input('nav_title'),
            'target_id' => $targetId,
            'show_in_nav' => $request->has('show_in_nav'),
            'is_active' => $request->has('is_active'),
            'orders' => $request->input('orders', $section->orders),
            'bg_type' => $bgType,
            'bg_color_class' => $bgColorClass,
            'bg_image' => $bgImage,
            'bg_position_y' => $request->input('bg_position_y', $section->bg_position_y ?? 50),
            'bg_size' => $request->input('bg_size', $section->bg_size ?? 'cover'),
            'bg_attachment' => $request->input('bg_attachment', $section->bg_attachment ?? 'scroll'),
            'bg_image_width' => $imgW,
            'bg_image_height' => $imgH,
            'bg_image_orientation' => $imgOrient,
        ]);

        WebsiteTheme::clearCache();

        $this->notifySuccess("Seksi halaman \"{$section->section_name}\" berhasil diperbarui.");

        return redirect()->route('admin.dukunganaplikasi.konfigurasi-website.index', ['theme_id' => $section->website_theme_id]);
    }

    /**
     * Delete section.
     */
    public function destroySection($id)
    {
        $section = WebsiteSection::findOrFail($id);
        $themeId = $section->website_theme_id;
        $name = $section->section_name;

        $section->delete();

        WebsiteTheme::clearCache();

        $this->notifySuccess("Seksi halaman \"{$name}\" berhasil dihapus.");

        return redirect()->route('admin.dukunganaplikasi.konfigurasi-website.index', ['theme_id' => $themeId]);
    }

    /**
     * Toggle active state of section via AJAX/Form.
     */
    public function toggleActiveSection($id)
    {
        $section = WebsiteSection::findOrFail($id);
        $section->update(['is_active' => !$section->is_active]);

        WebsiteTheme::clearCache();

        $statusStr = $section->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->notifySuccess("Seksi \"{$section->section_name}\" berhasil {$statusStr}.");

        return redirect()->back();
    }

    /**
     * Reorder sections.
     */
    public function reorderSections(Request $request)
    {
        $orders = $request->input('orders', []);
        foreach ($orders as $id => $orderVal) {
            WebsiteSection::where('id', $id)->update(['orders' => (int) $orderVal]);
        }

        WebsiteTheme::clearCache();

        $this->notifySuccess("Urutan seksi halaman berhasil diperbarui.");

        return redirect()->back();
    }

    /**
     * Update background position Y and background options of a section via AJAX.
     */
    public function updateSectionPosition(Request $request, $id)
    {
        $section = WebsiteSection::findOrFail($id);
        $posY = (int) $request->input('bg_position_y', $section->bg_position_y ?? 50);
        $bgSize = $request->input('bg_size', $section->bg_size ?? 'cover');
        $bgAttachment = $request->input('bg_attachment', $section->bg_attachment ?? 'scroll');

        $section->update([
            'bg_position_y' => $posY,
            'bg_size'       => $bgSize,
            'bg_attachment' => $bgAttachment,
        ]);
        WebsiteTheme::clearCache();

        return response()->json([
            'status'        => 'success',
            'message'       => "Pengaturan latar gambar seksi \"{$section->section_name}\" berhasil diperbarui.",
            'pos_y'         => $posY,
            'bg_size'       => $bgSize,
            'bg_attachment' => $bgAttachment,
        ]);
    }

    /**
     * Helper to get image dimensions & orientation.
     */
    private function getImageMeta($file)
    {
        if (!$file) return [null, null, null];
        try {
            $info = @getimagesize($file->getRealPath());
            if ($info && isset($info[0]) && isset($info[1])) {
                $w = $info[0];
                $h = $info[1];
                $orient = $w > $h ? 'landscape' : ($h > $w ? 'portrait' : 'square');
                return [$w, $h, $orient];
            }
        } catch (\Throwable $e) {}
        return [null, null, null];
    }
}
