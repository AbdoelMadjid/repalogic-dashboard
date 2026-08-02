<?php

namespace App\Http\Controllers\Admin\DukunganAplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DukunganAplikasi\FiturAplikasiRequest;
use App\Models\Admin\DukunganAplikasi\FiturAplikasi;
use App\Traits\HasNotification;
use Illuminate\Http\Request;

class FiturAplikasiController extends Controller
{
    use HasNotification;

    /**
     * Tampilkan halaman formulir fitur aplikasi.
     */
    public function index()
    {
        if (!auth()->user()->can('read dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $fitur = FiturAplikasi::getSettings();

        return view('admin.dukunganaplikasi.fitur-aplikasi', compact('fitur'));
    }

    /**
     * Toggle status per fitur via AJAX secara instan.
     */
    public function toggleFeature(Request $request)
    {
        if (!auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah fitur ini.',
            ], 403);
        }

        $request->validate([
            'feature' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $feature = $request->input('feature');
        $status = (bool) $request->input('status');

        $fitur = FiturAplikasi::getSettings();

        if (!array_key_exists($feature, $fitur->getAttributes())) {
            return response()->json([
                'success' => false,
                'message' => 'Fitur yang dipilih tidak valid.',
            ], 422);
        }

        $fitur->$feature = $status;
        $fitur->save();

        FiturAplikasi::clearCache();

        $labelName = ucwords(str_replace(['topbar_', 'menu_group_', '_'], ['', '', ' '], $feature));

        return response()->json([
            'success' => true,
            'message' => "Fitur {$labelName} berhasil " . ($status ? 'diaktifkan' : 'dinonaktifkan') . '.',
            'feature' => $feature,
            'status' => $status,
        ]);
    }

    /**
     * Toggle status masal per kelompok fitur (topbar / menu_group).
     */
    public function toggleGroup(Request $request)
    {
        if (!auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah fitur ini.',
            ], 403);
        }

        $request->validate([
            'group' => 'required|in:topbar,menu_group',
            'status' => 'required|boolean',
        ]);

        $group = $request->input('group');
        $status = (bool) $request->input('status');

        $fitur = FiturAplikasi::getSettings();

        if ($group === 'topbar') {
            $fields = [
                'topbar_search_box', 'topbar_megamenu_header', 'topbar_megamenu_apps',
                'topbar_theme_toggler', 'topbar_apps_dropdown', 'topbar_messages',
                'topbar_notifications', 'topbar_fullscreen', 'topbar_monochrome',
                'topbar_customizer', 'topbar_language', 'topbar_user_dropdown'
            ];
            $groupLabel = 'Semua Fitur Topbar';
        } else {
            $fields = [
                'menu_group_main', 'menu_group_apps', 'menu_group_custom_pages',
                'menu_group_layouts', 'menu_group_components', 'menu_group_documentation',
                'menu_group_menu_item', 'menu_special_menu'
            ];
            $groupLabel = 'Semua Group Menu Sidebar';
        }

        foreach ($fields as $field) {
            $fitur->$field = $status;
        }
        $fitur->save();

        FiturAplikasi::clearCache();

        return response()->json([
            'success' => true,
            'message' => "{$groupLabel} berhasil " . ($status ? 'ditampilkan' : 'disembunyikan') . '.',
            'group' => $group,
            'fields' => $fields,
            'status' => $status,
        ]);
    }

    /**
     * Perbarui data status fitur aplikasi.
     */
    public function update(FiturAplikasiRequest $request)
    {
        $fitur = FiturAplikasi::getSettings();

        $booleanFields = [
            'topbar_search_box',
            'topbar_megamenu_header',
            'topbar_megamenu_apps',
            'topbar_theme_toggler',
            'topbar_apps_dropdown',
            'topbar_messages',
            'topbar_notifications',
            'topbar_fullscreen',
            'topbar_monochrome',
            'topbar_customizer',
            'topbar_language',
            'topbar_user_dropdown',
            'menu_group_main',
            'menu_group_apps',
            'menu_group_custom_pages',
            'menu_group_layouts',
            'menu_group_components',
            'menu_group_documentation',
            'menu_group_menu_item',
            'menu_special_menu',
        ];

        $data = [];
        foreach ($booleanFields as $field) {
            $data[$field] = $request->boolean($field);
        }

        $fitur->update($data);
        FiturAplikasi::clearCache();

        $this->notifySuccess('Pengaturan Fitur Aplikasi berhasil diperbarui.', 'Berhasil!');

        return redirect()->route('admin.dukunganaplikasi.fitur-aplikasi.index');
    }
}
