<?php

namespace App\Http\Controllers\Admin\DukunganAplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DukunganAplikasi\ProfilAplikasiRequest;
use App\Models\Admin\DukunganAplikasi\ProfilAplikasi;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilAplikasiController extends Controller
{
    use HasNotification;

    /**
     * Tampilkan halaman formulir profil aplikasi.
     */
    public function index()
    {
        if (!auth()->user()->can('read dukunganaplikasi/profil-aplikasi') && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $profil = ProfilAplikasi::getSettings();

        return view('admin.dukunganaplikasi.profil-aplikasi', compact('profil'));
    }

    /**
     * Perbarui data profil aplikasi beserta logo dan meta.
     */
    public function update(ProfilAplikasiRequest $request)
    {
        $profil = ProfilAplikasi::getSettings();
        $data = $request->validated();

        // Handle image uploads
        $imageFields = ['logo_lg', 'logo_sm', 'favicon'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists in storage
                if ($profil->$field && Storage::disk('public')->exists($profil->$field)) {
                    Storage::disk('public')->delete($profil->$field);
                }

                // Store new file
                $path = $request->file($field)->store('uploads/profil', 'public');
                $data[$field] = $path;
            } else {
                unset($data[$field]);
            }
        }

        $profil->update($data);
        ProfilAplikasi::clearCache();

        $this->notifySuccess('Profil Aplikasi berhasil diperbarui.', 'Berhasil!');

        return redirect()->route('admin.dukunganaplikasi.profil-aplikasi.index');
    }
}
