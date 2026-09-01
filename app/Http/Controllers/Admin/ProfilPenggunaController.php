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
        $user = auth()->user()->load(['detail', 'config']);
        return view('admin.profil-pengguna', compact('user'));
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
     * Update complete KTP identity & detailed address information (user_details table).
     */
    public function updateDetail(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nik' => 'nullable|string|max:20',
            'telepon' => 'nullable|string|max:30',
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

    /**
     * Update user profile header cover background image & vertical position (user_configs table).
     */
    public function updateCover(Request $request)
    {
        $request->validate([
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:2048',
            'cover_position_y' => 'nullable|integer|min:0|max:100',
            'cover_height' => 'nullable|integer|min:150|max:800',
            'cover_color' => 'nullable|string|max:50',
            'cover_opacity' => 'nullable|integer|min:0|max:100',
            'cover_blur' => 'nullable|integer|min:0|max:30',
        ], [
            'cover_image.image' => 'Berkas foto sampul harus berupa gambar.',
            'cover_image.max' => 'Ukuran gambar foto sampul tidak boleh melebihi 2MB.',
            'cover_position_y.integer' => 'Nilai posisi vertikal tidak valid.',
            'cover_height.integer' => 'Nilai tinggi banner tidak valid.',
            'cover_height.min' => 'Tinggi banner minimal 150px.',
            'cover_height.max' => 'Tinggi banner maksimal 800px.',
            'cover_opacity.integer' => 'Ketebalan warna overlay tidak valid.',
            'cover_blur.integer' => 'Tingkat blur lapisan tidak valid.',
        ]);

        $user = auth()->user();
        $config = \App\Models\UserConfig::firstOrNew(['user_id' => $user->id]);

        if ($request->hasFile('cover_image')) {
            if (!empty($config->cover_image) && Storage::disk('public')->exists($config->cover_image)) {
                Storage::disk('public')->delete($config->cover_image);
            }

            $path = $request->file('cover_image')->store('covers', 'public');
            $config->cover_image = $path;
        }

        if ($request->has('cover_position_y')) {
            $config->cover_position_y = (int) $request->input('cover_position_y');
        }

        if ($request->has('cover_height')) {
            $config->cover_height = (int) $request->input('cover_height');
        }

        if ($request->has('cover_color')) {
            $config->cover_color = $request->input('cover_color');
        }

        if ($request->has('cover_opacity')) {
            $config->cover_opacity = (int) $request->input('cover_opacity');
        }

        if ($request->has('cover_blur')) {
            $config->cover_blur = (int) $request->input('cover_blur');
        }

        $config->save();

        $this->notifySuccess('Pengaturan foto sampul, warna lapisan & efek blur berhasil diperbarui.', 'Berhasil!');

        return redirect()->route('admin.profil-pengguna.index');
    }

    /**
     * Update user profile motto quote (user_configs table).
     */
    public function updateMotto(Request $request)
    {
        $request->validate([
            'motto' => 'required|string|max:255',
        ], [
            'motto.required' => 'Motto hidup tidak boleh kosong.',
            'motto.max' => 'Motto hidup maksimal 255 karakter.',
        ]);

        $user = auth()->user();
        $config = \App\Models\UserConfig::firstOrNew(['user_id' => $user->id]);
        $config->motto = $request->input('motto');
        $config->save();

        $this->notifySuccess('Motto hidup berhasil diperbarui.', 'Berhasil!');

        return redirect()->route('admin.profil-pengguna.index');
    }

    /**
     * Request account deactivation to administrator.
     */
    public function requestDeactivation(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $user->update([
            'deactivation_requested_at' => now(),
            'deactivation_reason' => $request->input('reason'),
        ]);

        $this->notifySuccess('Permintaan penonaktifan akun berhasil dikirimkan ke Administrator.', 'Permintaan Terkirim');

        return redirect()->route('admin.profil-pengguna.index');
    }

    /**
     * Cancel pending account deactivation request.
     */
    public function cancelDeactivation()
    {
        $user = auth()->user();

        $user->update([
            'deactivation_requested_at' => null,
            'deactivation_reason' => null,
        ]);

        $this->notifySuccess('Permintaan penonaktifan akun berhasil dibatalkan.', 'Dibatalkan');

        return redirect()->route('admin.profil-pengguna.index');
    }
}
