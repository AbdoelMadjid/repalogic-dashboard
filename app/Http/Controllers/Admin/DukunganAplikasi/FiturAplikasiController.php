<?php

namespace App\Http\Controllers\Admin\DukunganAplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DukunganAplikasi\FiturAplikasiRequest;
use App\Models\Admin\DukunganAplikasi\AppSetting;
use App\Models\Admin\DukunganAplikasi\FiturAplikasi;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FiturAplikasiController extends Controller
{
    use HasNotification;

    /**
     * Tampilkan halaman manajemen dan visibilitas fitur aplikasi.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('read dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $features = FiturAplikasi::orderBy('kategori', 'asc')
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalFeatures = $features->count();
        $activeFeatures = $features->where('status', true)->count();
        $inactiveFeatures = $features->where('status', false)->count();
        
        $categories = FiturAplikasi::select('kategori')
            ->distinct()
            ->orderBy('kategori', 'asc')
            ->pluck('kategori')
            ->toArray();

        $groupedFeatures = $features->groupBy('kategori');

        // Pengaturan Sistem Aplikasi (Persistent Database Settings)
        $appSettings = [
            'idle_timeout_minutes' => (int) AppSetting::get('idle_timeout_minutes', 5),
            'maintenance_mode' => (bool) AppSetting::get('maintenance_mode', false),
            'maintenance_message' => AppSetting::get('maintenance_message', 'Sistem sedang dalam proses pemeliharaan berkala. Silakan coba beberapa saat lagi.'),
            'rate_limit_attempts' => (int) AppSetting::get('rate_limit_attempts', 5),
            'auto_user_approval' => (bool) AppSetting::get('auto_user_approval', false),
            'new_device_alert' => (bool) AppSetting::get('new_device_alert', true),
            'polling_interval' => (int) AppSetting::get('polling_interval', 20),
            'sound_notification' => (bool) AppSetting::get('sound_notification', true),
            'toast_notification' => (bool) AppSetting::get('toast_notification', true),
        ];

        return view('admin.dukunganaplikasi.fitur-aplikasi', compact(
            'features',
            'groupedFeatures',
            'categories',
            'totalFeatures',
            'activeFeatures',
            'inactiveFeatures',
            'appSettings'
        ));
    }

    /**
     * Simpan fitur baru ke database.
     */
    public function store(FiturAplikasiRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? (bool) $request->input('status') : true;
        $data['urutan'] = $request->input('urutan', 0) ?? 0;
        $data['is_system'] = false;

        $feature = FiturAplikasi::create($data);
        FiturAplikasi::clearCache();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Fitur '{$feature->nama_fitur}' berhasil ditambahkan.",
                'data' => $feature,
            ]);
        }

        $this->notifySuccess("Fitur '{$feature->nama_fitur}' berhasil ditambahkan.", 'Berhasil!');
        return redirect()->route('admin.dukunganaplikasi.fitur-aplikasi.index');
    }

    /**
     * Perbarui data fitur aplikasi yang sudah ada.
     */
    public function update(FiturAplikasiRequest $request, $id)
    {
        $feature = FiturAplikasi::findOrFail($id);

        $data = $request->validated();
        $data['status'] = $request->has('status') ? (bool) $request->input('status') : false;
        $data['urutan'] = $request->input('urutan', 0) ?? 0;

        $feature->update($data);
        FiturAplikasi::clearCache();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Fitur '{$feature->nama_fitur}' berhasil diperbarui.",
                'data' => $feature,
            ]);
        }

        $this->notifySuccess("Fitur '{$feature->nama_fitur}' berhasil diperbarui.", 'Berhasil!');
        return redirect()->route('admin.dukunganaplikasi.fitur-aplikasi.index');
    }

    /**
     * Hapus data fitur aplikasi dari database.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus fitur ini.');
        }

        $feature = FiturAplikasi::findOrFail($id);
        $featureName = $feature->nama_fitur;
        $feature->delete();

        FiturAplikasi::clearCache();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Fitur '{$featureName}' berhasil dihapus.",
            ]);
        }

        $this->notifySuccess("Fitur '{$featureName}' berhasil dihapus.", 'Berhasil!');
        return redirect()->route('admin.dukunganaplikasi.fitur-aplikasi.index');
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
            'id' => 'nullable|integer',
            'feature' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $id = $request->input('id');
        $featureKey = $request->input('feature');
        $status = (bool) $request->input('status');

        if ($id) {
            $feature = FiturAplikasi::find($id);
        } elseif ($featureKey) {
            $feature = FiturAplikasi::where('kode_fitur', $featureKey)->first();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Identifikasi fitur tidak valid.',
            ], 422);
        }

        if (!$feature) {
            return response()->json([
                'success' => false,
                'message' => 'Fitur tidak ditemukan di database.',
            ], 404);
        }

        $feature->status = $status;
        $feature->save();

        FiturAplikasi::clearCache();

        return response()->json([
            'success' => true,
            'message' => "Fitur '{$feature->nama_fitur}' berhasil " . ($status ? 'diaktifkan' : 'dinonaktifkan') . '.',
            'id' => $feature->id,
            'feature' => $feature->kode_fitur,
            'status' => $status,
        ]);
    }

    /**
     * Toggle status masal per kelompok / kategori fitur.
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
            'group' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $group = $request->input('group');
        $status = (bool) $request->input('status');

        $affected = FiturAplikasi::where('kategori', $group)->update(['status' => $status]);
        FiturAplikasi::clearCache();

        $groupLabel = strtoupper($group);

        return response()->json([
            'success' => true,
            'message' => "Semua fitur dalam kelompok '{$groupLabel}' ({$affected} fitur) berhasil " . ($status ? 'diaktifkan' : 'dinonaktifkan') . '.',
            'group' => $group,
            'status' => $status,
            'affected' => $affected,
        ]);
    }

    /**
     * Aksi massal (Aktifkan, Nonaktifkan, Hapus) untuk fitur yang dipilih via checkbox.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:enable,disable,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:fitur_aplikasi,id',
        ]);

        $action = $request->input('action');
        $ids = $request->input('ids');

        if ($action === 'delete') {
            if (!auth()->user()->can('delete dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menghapus fitur ini.',
                ], 403);
            }

            $count = FiturAplikasi::whereIn('id', $ids)->delete();
            FiturAplikasi::clearCache();

            return response()->json([
                'success' => true,
                'message' => "{$count} fitur terpilih berhasil dihapus dari sistem.",
                'action' => 'delete',
                'affected' => $count,
                'ids' => $ids,
            ]);
        }

        if (!auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah fitur ini.',
            ], 403);
        }

        $newStatus = ($action === 'enable');
        $count = FiturAplikasi::whereIn('id', $ids)->update(['status' => $newStatus]);
        FiturAplikasi::clearCache();

        $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json([
            'success' => true,
            'message' => "{$count} fitur terpilih berhasil {$statusText}.",
            'action' => $action,
            'status' => $newStatus,
            'affected' => $count,
            'ids' => $ids,
        ]);
    }

    /**
     * Bersihkan seluruh cache sistem (views, config, routes, app cache).
     */
    public function clearSystemCache(Request $request)
    {
        if (!auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk membersihkan cache sistem.',
            ], 403);
        }

        try {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');

            FiturAplikasi::clearCache();
            \App\Models\Admin\DukunganAplikasi\ProfilAplikasi::clearCache();
            AppSetting::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Seluruh cache sistem (Views, Config, Routes, Application Cache) berhasil dibersihkan!',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membersihkan cache: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simpan konfigurasi setting aplikasi via AJAX.
     */
    public function updateAppSetting(Request $request)
    {
        if (!auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah konfigurasi aplikasi.',
            ], 403);
        }

        $request->validate([
            'key' => 'required|string',
            'value' => 'nullable',
        ]);

        $key = $request->input('key');
        $value = $request->input('value');

        AppSetting::set($key, $value);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan ke sistem.',
            'key' => $key,
            'value' => $value,
        ]);
    }

    /**
     * Kembalikan seluruh pengaturan sistem dan visibilitas fitur ke setelan default seeder.
     */
    public function resetDefaults(Request $request)
    {
        if (!auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mereset pengaturan fitur.',
            ], 403);
        }

        try {
            // 1. Reset Application Settings from AppSettingSeeder default dictionary
            $defaultSettings = [
                'idle_timeout_minutes' => '5',
                'maintenance_mode' => '0',
                'maintenance_message' => 'Sistem sedang dalam proses pemeliharaan berkala. Silakan coba beberapa saat lagi.',
                'rate_limit_attempts' => '5',
                'auto_user_approval' => '0',
                'new_device_alert' => '1',
                'polling_interval' => '20',
                'sound_notification' => '1',
                'toast_notification' => '1',
            ];

            foreach ($defaultSettings as $key => $value) {
                AppSetting::set($key, $value);
            }

            // 2. Run FiturAplikasiSeeder to restore default features and statuses
            $seeder = new \Database\Seeders\FiturAplikasiSeeder();
            $seeder->run();

            // 3. Clear Caches
            AppSetting::clearCache();
            FiturAplikasi::clearCache();
            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return response()->json([
                'success' => true,
                'message' => 'Seluruh Pusat Kontrol & Fitur Aplikasi berhasil dikembalikan ke pengaturan default pabrik (seeder)!',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset pengaturan ke default: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Memindai seluruh berkas gambar di penyimpanan (storage) dan membandingkannya dengan database.
     */
    public function scanStorageImages(Request $request)
    {
        if (!auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk memindai berkas penyimpanan.',
            ], 403);
        }

        try {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico', 'avif'];
            $allStorageFiles = Storage::disk('public')->allFiles();

            $dbReferences = $this->getDatabaseReferencedMedia();

            $totalStorageImages = 0;
            $totalStorageBytes = 0;
            $validImagesCount = 0;
            $orphanedFiles = [];
            $orphanedBytes = 0;
            $folderCounts = [];

            foreach ($allStorageFiles as $file) {
                // Ignore .gitignore and hidden files
                if (basename($file) === '.gitignore' || str_starts_with(basename($file), '.')) {
                    continue;
                }

                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExtensions)) {
                    continue;
                }

                $totalStorageImages++;
                $fileSize = Storage::disk('public')->size($file);
                $totalStorageBytes += $fileSize;

                $normalizedFile = str_replace('\\', '/', $file);
                $normalizedFile = trim($normalizedFile, '/');
                $filenameOnly = basename($normalizedFile);

                // Check if file is referenced in database
                $isReferenced = isset($dbReferences[$normalizedFile]) || isset($dbReferences[$filenameOnly]);

                $folderName = dirname($normalizedFile);
                if ($folderName === '.' || empty($folderName)) {
                    $folderName = 'root';
                }

                if ($isReferenced) {
                    $validImagesCount++;
                } else {
                    $orphanedBytes += $fileSize;
                    $lastModified = Storage::disk('public')->lastModified($file);

                    if (!isset($folderCounts[$folderName])) {
                        $folderCounts[$folderName] = 0;
                    }
                    $folderCounts[$folderName]++;

                    $orphanedFiles[] = [
                        'path' => $normalizedFile,
                        'filename' => $filenameOnly,
                        'folder' => $folderName,
                        'extension' => strtoupper($ext),
                        'size_bytes' => $fileSize,
                        'size_formatted' => $this->formatBytes($fileSize),
                        'last_modified' => $lastModified,
                        'url' => asset('storage/' . $normalizedFile),
                        'relative_url' => '/storage/' . $normalizedFile,
                        'storage_location' => 'storage/app/public/' . $normalizedFile,
                    ];
                }
            }

            // Sort orphaned files by last modified descending
            usort($orphanedFiles, function ($a, $b) {
                return $b['last_modified'] <=> $a['last_modified'];
            });

            return response()->json([
                'success' => true,
                'message' => 'Pemindaian berkas media penyimpanan berhasil diselesaikan.',
                'summary' => [
                    'total_storage_images' => $totalStorageImages,
                    'total_storage_size' => $this->formatBytes($totalStorageBytes),
                    'total_valid_images' => $validImagesCount,
                    'total_orphaned_images' => count($orphanedFiles),
                    'orphaned_size_bytes' => $orphanedBytes,
                    'orphaned_size_formatted' => $this->formatBytes($orphanedBytes),
                    'folders' => $folderCounts,
                    'scanned_at' => now()->translatedFormat('d F Y, H:i:s') . ' WIB',
                ],
                'orphaned_files' => $orphanedFiles,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memindai berkas media: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Menghapus gambar-gambar orphan (tidak terhubung dengan database) dari storage.
     */
    public function deleteStorageImages(Request $request)
    {
        if (!auth()->user()->can('delete dukunganaplikasi/fitur-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus berkas penyimpanan.',
            ], 403);
        }

        $request->validate([
            'paths' => 'nullable|array',
            'paths.*' => 'string',
            'delete_all' => 'nullable|boolean',
        ]);

        try {
            $dbReferences = $this->getDatabaseReferencedMedia();
            $deleteAll = (bool) $request->input('delete_all', false);
            $requestedPaths = $request->input('paths', []);

            $deletedCount = 0;
            $freedBytes = 0;
            $failedFiles = [];

            if ($deleteAll) {
                // Get all orphaned files again directly from storage to prevent deleting active files
                $allStorageFiles = Storage::disk('public')->allFiles();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico', 'avif'];

                foreach ($allStorageFiles as $file) {
                    if (basename($file) === '.gitignore' || str_starts_with(basename($file), '.')) {
                        continue;
                    }

                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if (!in_array($ext, $allowedExtensions)) {
                        continue;
                    }

                    $normalizedFile = str_replace('\\', '/', $file);
                    $normalizedFile = trim($normalizedFile, '/');
                    $filenameOnly = basename($normalizedFile);

                    // Skip active/valid database files!
                    if (isset($dbReferences[$normalizedFile]) || isset($dbReferences[$filenameOnly])) {
                        continue;
                    }

                    if (Storage::disk('public')->exists($file)) {
                        $fileSize = Storage::disk('public')->size($file);
                        if (Storage::disk('public')->delete($file)) {
                            $deletedCount++;
                            $freedBytes += $fileSize;
                        } else {
                            $failedFiles[] = $file;
                        }
                    }
                }
            } else {
                if (empty($requestedPaths)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada berkas yang dipilih untuk dihapus.',
                    ], 422);
                }

                foreach ($requestedPaths as $rawPath) {
                    $normalizedFile = str_replace('\\', '/', $rawPath);
                    $normalizedFile = trim($normalizedFile, '/');
                    $filenameOnly = basename($normalizedFile);

                    // Safety Guard: never delete active files in DB!
                    if (isset($dbReferences[$normalizedFile]) || isset($dbReferences[$filenameOnly])) {
                        continue;
                    }

                    if (Storage::disk('public')->exists($normalizedFile)) {
                        $fileSize = Storage::disk('public')->size($normalizedFile);
                        if (Storage::disk('public')->delete($normalizedFile)) {
                            $deletedCount++;
                            $freedBytes += $fileSize;
                        } else {
                            $failedFiles[] = $normalizedFile;
                        }
                    }
                }
            }

            $freedFormatted = $this->formatBytes($freedBytes);

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} gambar tidak terpakai ({$freedFormatted} ruang disk dibebaskan).",
                'deleted_count' => $deletedCount,
                'freed_bytes' => $freedBytes,
                'freed_formatted' => $freedFormatted,
                'failed_files' => $failedFiles,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus berkas media: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Mengumpulkan semua referensi berkas aktif dari database untuk proteksi dan sinkronisasi.
     */
    private function getDatabaseReferencedMedia(): array
    {
        $dbPaths = collect();

        // 1. User avatar
        if (class_exists(\App\Models\User::class)) {
            $dbPaths = $dbPaths->merge(\App\Models\User::whereNotNull('avatar')->where('avatar', '!=', '')->pluck('avatar'));
        }

        // 2. UserDetail foto_ktp
        if (class_exists(\App\Models\UserDetail::class)) {
            $dbPaths = $dbPaths->merge(\App\Models\UserDetail::whereNotNull('foto_ktp')->where('foto_ktp', '!=', '')->pluck('foto_ktp'));
        }

        // 3. UserConfig cover_image
        if (class_exists(\App\Models\UserConfig::class)) {
            $dbPaths = $dbPaths->merge(\App\Models\UserConfig::whereNotNull('cover_image')->where('cover_image', '!=', '')->pluck('cover_image'));
        }

        // 4. ProfilAplikasi logo_lg, logo_sm, favicon
        if (class_exists(\App\Models\Admin\DukunganAplikasi\ProfilAplikasi::class)) {
            $profil = \App\Models\Admin\DukunganAplikasi\ProfilAplikasi::first();
            if ($profil) {
                if (!empty($profil->logo_lg)) $dbPaths->push($profil->logo_lg);
                if (!empty($profil->logo_sm)) $dbPaths->push($profil->logo_sm);
                if (!empty($profil->favicon)) $dbPaths->push($profil->favicon);
            }
        }

        // 5. WebsiteSection bg_image
        if (class_exists(\App\Models\Admin\DukunganAplikasi\WebsiteSection::class)) {
            $dbPaths = $dbPaths->merge(\App\Models\Admin\DukunganAplikasi\WebsiteSection::whereNotNull('bg_image')->where('bg_image', '!=', '')->pluck('bg_image'));
        }

        // 6. Message attachment
        if (class_exists(\App\Models\Message::class)) {
            $dbPaths = $dbPaths->merge(\App\Models\Message::whereNotNull('attachment_url')->where('attachment_url', '!=', '')->pluck('attachment_url'));
        }

        // Normalize all db paths
        $normalizedPaths = [];
        foreach ($dbPaths->filter()->unique() as $rawPath) {
            $clean = str_replace(['\\', '/storage/', 'storage/', 'public/'], ['/', '', '', ''], $rawPath);
            $clean = trim($clean, '/');
            if (!empty($clean)) {
                $normalizedPaths[$clean] = true;
                // Also add basename for matching
                $normalizedPaths[basename($clean)] = true;
            }
        }

        return $normalizedPaths;
    }
}
