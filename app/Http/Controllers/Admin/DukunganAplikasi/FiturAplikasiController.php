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

        return view('admin.dukunganaplikasi.fitur-aplikasi', compact(
            'features',
            'groupedFeatures',
            'categories',
            'totalFeatures',
            'activeFeatures',
            'inactiveFeatures'
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
}
