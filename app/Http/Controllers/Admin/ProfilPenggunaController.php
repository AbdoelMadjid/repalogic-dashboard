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
        $settings = $user->getAllSettings();
        $recentActivities = \App\Models\Admin\ManajemenPengguna\ActivityLog::where('causer_id', $user->id)
            ->latest()
            ->take(15)
            ->get();

        return view('admin.profil-pengguna', compact('user', 'settings', 'recentActivities'));
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

        // Handle Cropped Avatar File Upload (True 1:1 Pixel-Perfect Square Avatar)
        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;

            \App\Models\UserMediaHistory::create([
                'user_id' => $user->id,
                'media_type' => 'avatar',
                'file_path' => $path,
                'file_name' => $request->file('avatar')->getClientOriginalName(),
                'description' => 'Pembaruan Foto Avatar Profil',
                'meta_data' => [
                    'source' => 'profil_pengguna',
                    'updated_at' => now()->toDateTimeString(),
                ],
            ]);
        }

        $user->save();

        // Handle Master Original Photo & Crop Coordinates in UserConfig Settings
        $config = \App\Models\UserConfig::firstOrNew(['user_id' => $user->id]);
        $settings = $config->settings ?? [];
        $settingsUpdated = false;

        if ($request->hasFile('avatar_original')) {
            $oldOriginal = $settings['avatar_original'] ?? null;
            if (!empty($oldOriginal) && Storage::disk('public')->exists($oldOriginal)) {
                Storage::disk('public')->delete($oldOriginal);
            }

            $origPath = $request->file('avatar_original')->store('avatars/originals', 'public');
            $settings['avatar_original'] = $origPath;
            $settingsUpdated = true;
        }

        if ($request->filled('avatar_crop_data')) {
            $cropData = json_decode($request->input('avatar_crop_data'), true);
            if (is_array($cropData)) {
                $settings['avatar_crop_data'] = $cropData;
                $settingsUpdated = true;
            }
        }

        if ($settingsUpdated) {
            $config->settings = $settings;
            $config->save();
        }

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

            \App\Models\UserMediaHistory::create([
                'user_id' => $user->id,
                'media_type' => 'cover',
                'file_path' => $path,
                'file_name' => $request->file('cover_image')->getClientOriginalName(),
                'description' => 'Pembaruan Foto Sampul Banner',
                'meta_data' => [
                    'position_y' => (int) $request->input('cover_position_y', $config->cover_position_y ?? 50),
                    'height' => (int) $request->input('cover_height', $config->cover_height ?? 320),
                    'blur' => (int) $request->input('cover_blur', $config->cover_blur ?? 0),
                    'color' => $request->input('cover_color', $config->cover_color ?? '#313a46'),
                ],
            ]);
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
     * Update user profile motto quote and text color (user_configs table).
     */
    public function updateMotto(Request $request)
    {
        $request->validate([
            'motto' => 'required|string|max:255',
            'motto_color' => ['nullable', 'string', 'max:50', 'regex:/^(#[a-fA-F0-9]{3,8}|rgba?\([\d\s,\.]+\)|[a-zA-Z]+)$/'],
        ], [
            'motto.required' => 'Motto hidup tidak boleh kosong.',
            'motto.max' => 'Motto hidup maksimal 255 karakter.',
            'motto_color.regex' => 'Format kode warna teks tidak valid.',
        ]);

        $user = auth()->user();
        $config = \App\Models\UserConfig::firstOrNew(['user_id' => $user->id]);
        $config->motto = $request->input('motto');
        $config->motto_color = $request->input('motto_color', '#ffffff') ?: '#ffffff';
        $config->save();

        $this->notifySuccess('Motto hidup & warna teks berhasil diperbarui.', 'Berhasil!');

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

    /**
     * Update self-service user settings (user_configs table JSON column).
     */
    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        $currentSettings = $user->getAllSettings();

        $request->validate([
            // Chat
            'chat_who_can_message' => 'nullable|in:everyone,friends,none',
            'chat_read_receipts' => 'nullable|boolean',
            'chat_online_status_visibility' => 'nullable|in:everyone,friends,hide',
            'chat_sound_alert' => 'nullable|in:default,pop,ding,mute',
            'chat_send_on_enter' => 'nullable|boolean',
            // Lock Screen & Security
            'lock_screen_auto_lock_timeout' => 'nullable|integer|in:0,5,15,30,60',
            // Appearance
            'appearance_theme_mode' => 'nullable|in:light,dark,system',
            'appearance_sidebar_style' => 'nullable|in:default,compact,icon',
            'appearance_table_density' => 'nullable|in:normal,compact',
            'appearance_reduce_motion' => 'nullable|boolean',
            // Notifications
            'notifications_browser_push' => 'nullable|boolean',
            'notifications_sound_chime' => 'nullable|boolean',
            'notifications_events_friend_request' => 'nullable|boolean',
            'notifications_events_profile_like' => 'nullable|boolean',
            'notifications_events_chat_message' => 'nullable|boolean',
            'notifications_events_security_alert' => 'nullable|boolean',
            'notifications_events_global_announcement' => 'nullable|boolean',
            // Privacy
            'privacy_profile_visibility' => 'nullable|in:public,friends,private',
            'privacy_allow_likes' => 'nullable|boolean',
            'privacy_show_points' => 'nullable|boolean',
            'privacy_allow_friend_requests' => 'nullable|in:everyone,friends_of_friends,none',
            // Localization
            'localization_locale' => 'nullable|in:id,en',
            'localization_timezone' => 'nullable|in:Asia/Jakarta,Asia/Makassar,Asia/Jayapura,UTC',
            'localization_date_format' => 'nullable|in:DD/MM/YYYY,YYYY-MM-DD,DD MMMM YYYY',
        ]);

        $newSettings = $currentSettings;

        // Process Chat settings
        if ($request->has('has_chat_settings')) {
            $newSettings['chat']['who_can_message'] = $request->input('chat_who_can_message', $currentSettings['chat']['who_can_message'] ?? 'everyone');
            $newSettings['chat']['read_receipts'] = $request->boolean('chat_read_receipts');
            $newSettings['chat']['online_status_visibility'] = $request->input('chat_online_status_visibility', $currentSettings['chat']['online_status_visibility'] ?? 'everyone');
            $newSettings['chat']['sound_alert'] = $request->input('chat_sound_alert', $currentSettings['chat']['sound_alert'] ?? 'pop');
            $newSettings['chat']['send_on_enter'] = $request->boolean('chat_send_on_enter');
        }

        // Process Appearance settings
        if ($request->has('has_appearance_settings')) {
            $newSettings['appearance']['theme_mode'] = $request->input('appearance_theme_mode', $currentSettings['appearance']['theme_mode'] ?? 'system');
            $newSettings['appearance']['sidebar_style'] = $request->input('appearance_sidebar_style', $currentSettings['appearance']['sidebar_style'] ?? 'default');
            $newSettings['appearance']['table_density'] = $request->input('appearance_table_density', $currentSettings['appearance']['table_density'] ?? 'normal');
            $newSettings['appearance']['reduce_motion'] = $request->boolean('appearance_reduce_motion');

            // Sync theme_mode column directly on user_configs table
            $config = \App\Models\UserConfig::firstOrNew(['user_id' => $user->id]);
            $config->theme_mode = $newSettings['appearance']['theme_mode'];
            $config->save();
        }

        // Process Notifications settings
        if ($request->has('has_notification_settings')) {
            $newSettings['notifications']['browser_push'] = $request->boolean('notifications_browser_push');
            $newSettings['notifications']['sound_chime'] = $request->boolean('notifications_sound_chime');
            $newSettings['notifications']['events']['friend_request'] = $request->boolean('notifications_events_friend_request');
            $newSettings['notifications']['events']['profile_like'] = $request->boolean('notifications_events_profile_like');
            $newSettings['notifications']['events']['chat_message'] = $request->boolean('notifications_events_chat_message');
            $newSettings['notifications']['events']['security_alert'] = $request->boolean('notifications_events_security_alert');
            $newSettings['notifications']['events']['global_announcement'] = $request->boolean('notifications_events_global_announcement');
        }

        // Process Privacy, Lock screen & Localization settings
        if ($request->has('has_privacy_security_settings')) {
            $newSettings['privacy']['profile_visibility'] = $request->input('privacy_profile_visibility', $currentSettings['privacy']['profile_visibility'] ?? 'public');
            $newSettings['privacy']['allow_likes'] = $request->boolean('privacy_allow_likes');
            $newSettings['privacy']['show_points'] = $request->boolean('privacy_show_points');
            $newSettings['privacy']['allow_friend_requests'] = $request->input('privacy_allow_friend_requests', $currentSettings['privacy']['allow_friend_requests'] ?? 'everyone');

            $newSettings['lock_screen']['auto_lock_timeout'] = (int) $request->input('lock_screen_auto_lock_timeout', $currentSettings['lock_screen']['auto_lock_timeout'] ?? 15);

            $newSettings['localization']['locale'] = $request->input('localization_locale', $currentSettings['localization']['locale'] ?? 'id');
            $newSettings['localization']['timezone'] = $request->input('localization_timezone', $currentSettings['localization']['timezone'] ?? 'Asia/Jakarta');
            $newSettings['localization']['date_format'] = $request->input('localization_date_format', $currentSettings['localization']['date_format'] ?? 'DD/MM/YYYY');
        }

        $config = \App\Models\UserConfig::firstOrNew(['user_id' => $user->id]);
        $config->settings = $newSettings;
        $config->save();

        \App\Models\Admin\ManajemenPengguna\ActivityLog::log(
            'Memperbarui Preferensi & Pengaturan Mandiri Profil Pengguna',
            $user,
            'updated',
            [
                'updated_sections' => array_values(array_filter([
                    $request->has('has_chat_settings') ? 'Pesan & Obrolan' : null,
                    $request->has('has_appearance_settings') ? 'Tampilan & Tema' : null,
                    $request->has('has_notification_settings') ? 'Notifikasi & Suara' : null,
                    $request->has('has_privacy_security_settings') ? 'Privasi, Keamanan Sesi & Regional' : null,
                ])),
            ],
            'profil_pengguna'
        );

        $this->notifySuccess('Preferensi dan pengaturan mandiri profil Anda berhasil disimpan.', 'Pengaturan Tersimpan!');

        return redirect()->route('admin.profil-pengguna.index');
    }
}
