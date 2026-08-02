<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilPenggunaRequest;
use App\Models\UserDetail;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilPenggunaController extends Controller
{
    use HasNotification;

    /**
     * Display the logged in user's profile view.
     */
    public function index()
    {
        $user = auth()->user()->load('detail');
        return view('admin.profil-pengguna.profil-pengguna', compact('user'));
    }

    /**
     * Update basic user account info via Modal on index page (Avatar, Name, Email, Password).
     */
    public function updateQuick(ProfilPenggunaRequest $request)
    {
        $user = auth()->user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Handle Avatar File Upload
        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        $this->notifySuccess('Profil utama Anda berhasil diperbarui.', 'Berhasil!');

        return redirect()->route('admin.profil-pengguna.index');
    }

    /**
     * Display the edit KTP detail & full address form view (edit in partials).
     */
    public function edit()
    {
        $user = auth()->user()->load('detail');
        $detail = $user->detail ?? new UserDetail();

        return view('admin.profil-pengguna.partials.edit', compact('user', 'detail'));
    }

    /**
     * Update complete KTP identity & detailed address information (user_details table).
     */
    public function updateDetail(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nik' => 'nullable|string|max:20',
            'nama_ktp' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-Laki,Perempuan',
            'golongan_darah' => 'nullable|string|max:5',
            'agama' => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:50',
            'alamat_jalan' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'blok' => 'nullable|string|max:20',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'foto_ktp' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $detail = UserDetail::firstOrNew(['user_id' => $user->id]);

        $detail->fill($validated);

        // Handle Foto KTP File Upload
        if ($request->hasFile('foto_ktp')) {
            if (!empty($detail->foto_ktp) && Storage::disk('public')->exists($detail->foto_ktp)) {
                Storage::disk('public')->delete($detail->foto_ktp);
            }

            $ktpPath = $request->file('foto_ktp')->store('ktp', 'public');
            $detail->foto_ktp = $ktpPath;
        }

        $detail->save();

        $this->notifySuccess('Kelengkapan data KTP & Alamat berhasil disimpan.', 'Berhasil!');

        return redirect()->route('admin.profil-pengguna.index');
    }
}
