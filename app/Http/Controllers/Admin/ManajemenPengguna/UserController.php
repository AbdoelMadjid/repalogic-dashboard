<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManajemenPengguna\UserRequest;
use App\Models\User;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    use HasNotification;

    /**
     * Display a listing of users and available Spatie roles.
     */
    public function index(Request $request)
    {
        $users = User::with(['roles', 'approver', 'detail', 'config'])->latest()->get();
        foreach ($users as $user) {
            $user->role_names = $user->roles->pluck('name')->toArray();
        }
        $roles = Role::all();

        return view('admin.manajemenpengguna.users', compact('users', 'roles'));
    }

    public function create()
    {
        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Store a newly created user account.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'avatar' => $avatarPath,
            'status' => $validated['status'] ?? 'active',
            'approved_at' => ($validated['status'] ?? 'active') === 'active' ? now() : null,
            'approved_by' => ($validated['status'] ?? 'active') === 'active' ? auth()->id() : null,
        ]);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Pengguna baru \"{$user->name}\" berhasil ditambahkan.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    public function show($id)
    {
        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    public function edit($id)
    {
        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Update the specified user profile and roles.
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        $userData = [
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
        ];

        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('remove_avatar')) {
            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = null;
        }

        if (isset($validated['status'])) {
            $userData['status'] = $validated['status'];
            if ($validated['status'] === 'active' && $user->status === 'pending') {
                $userData['approved_at'] = now();
                $userData['approved_by'] = auth()->id();
            }
        }

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Data pengguna \"{$user->name}\" berhasil diperbarui.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Approve self-registered user and assign default 'user' role.
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);

        // Pastikan role 'user' tersedia
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $user->update([
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        // Otomatis assign role 'user' jika akun belum memiliki role
        if ($user->roles->isEmpty()) {
            $user->assignRole('user');
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Akun pengguna \"{$user->name}\" berhasil disetujui & diaktifkan dengan Role User.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Reset user password to standard default password ("password*").
     */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make('password*'),
            'password_reset_requested_at' => null,
        ]);

        $this->notifySuccess("Password pengguna \"{$user->name}\" berhasil di-reset menjadi \"password*\".");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Deactivate user upon request.
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            $this->notifyError("Anda tidak dapat menonaktifkan akun Anda sendiri dari sini.");
            return redirect()->route('admin.manajemenpengguna.users.index');
        }

        $user->update([
            'status' => 'inactive',
            'deactivation_requested_at' => null,
            'deactivation_reason' => null,
        ]);

        // Hancurkan seluruh sesi aktif akun ini dan bersihkan status online
        try {
            \Illuminate\Support\Facades\DB::table('sessions')->where('user_id', $user->id)->delete();
        } catch (\Throwable $e) {}

        \Illuminate\Support\Facades\Cache::forget('user-online-' . $user->id);
        $onlineList = \Illuminate\Support\Facades\Cache::get('online-users-list', []);
        if (in_array($user->id, $onlineList)) {
            $onlineList = array_values(array_diff($onlineList, [$user->id]));
            \Illuminate\Support\Facades\Cache::put('online-users-list', $onlineList, now()->addMinutes(3));
        }

        $this->notifySuccess("Akun pengguna \"{$user->name}\" telah dinonaktifkan sesuai permohonan.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Reject self-registration request.
     */
    public function rejectRegistration(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $reason = trim($request->input('reason', 'Pendaftaran tidak disetujui oleh Administrator.'));

        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);

        try {
            $convId = \App\Models\Message::makeConversationId(auth()->id(), $user->id);

            \App\Models\Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $user->id,
                'conversation_id' => $convId,
                'subject' => 'Pendaftaran Akun Ditolak',
                'body' => "Pendaftaran akun Anda ditolak oleh Administrator.",
                'reason' => $reason,
                'message_type' => 'registration_rejected',
                'is_read' => false,
            ]);
        } catch (\Throwable $e) {}

        $this->notifySuccess("Pendaftaran pengguna \"{$user->name}\" berhasil ditolak.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Reject user deactivation request and send notification message to the user.
     */
    public function rejectDeactivation(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $reason = trim($request->input('reason', 'Permohonan penonaktifan tidak disetujui oleh Administrator.'));

        $user->update([
            'deactivation_requested_at' => null,
            'deactivation_reason' => null,
        ]);

        // Kirim pesan ke tabel messages & notifikasi dengan conversation_id
        try {
            $convId = \App\Models\Message::makeConversationId(auth()->id(), $user->id);

            \App\Models\Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $user->id,
                'conversation_id' => $convId,
                'subject' => 'Permohonan Non Aktif Akun Ditolak',
                'body' => "Permohonan penonaktifan akun Anda ditolak oleh Administrator.",
                'reason' => $reason,
                'message_type' => 'deactivation_rejected',
                'is_read' => false,
            ]);

            $user->notifications()->create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'type' => 'deactivation_rejected',
                'data' => [
                    'title' => 'Permohonan Non Aktif Akun Ditolak',
                    'subtitle' => 'Permohonan non aktif akun Anda ditolak oleh Administrator.',
                    'message' => 'Permohonan non aktif akun Anda ditolak oleh Administrator.',
                    'reason' => $reason,
                    'icon' => 'ti ti-user-x',
                    'badge_class' => 'bg-danger-subtle text-danger border-danger-subtle',
                    'badge_label' => 'Penonaktifan Ditolak',
                    'url' => route('admin.profil-pengguna.messages.index', ['user_id' => auth()->id()]),
                ],
                'read_at' => null,
            ]);
        } catch (\Throwable $e) {
            // Silently fallback if notifications table issue
        }

        $this->notifySuccess("Permohonan penonaktifan pengguna \"{$user->name}\" telah ditolak & notifikasi dikirimkan.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Activate user upon reactivation request.
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'active',
            'reactivation_requested_at' => null,
            'reactivation_reason' => null,
        ]);

        $this->notifySuccess("Akun pengguna \"{$user->name}\" berhasil diaktifkan kembali.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Toggle status active / inactive for user.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            $this->notifyError("Anda tidak dapat mengubah status akun Anda sendiri.");
            return redirect()->route('admin.manajemenpengguna.users.index');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $updateData = ['status' => $newStatus];
        if ($newStatus === 'inactive') {
            $updateData['deactivation_requested_at'] = null;
            $updateData['deactivation_reason'] = null;
        } elseif ($newStatus === 'active') {
            $updateData['reactivation_requested_at'] = null;
            $updateData['reactivation_reason'] = null;
        }

        $user->update($updateData);

        $label = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        $this->notifySuccess("Status akun \"{$user->name}\" berhasil {$label}.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Remove the specified user account.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            $this->notifyError("Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.");
            return redirect()->route('admin.manajemenpengguna.users.index');
        }

        if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Pengguna \"{$user->name}\" berhasil dihapus.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Switch / Impersonate to another user account.
     */
    public function switchAccount(Request $request, $id)
    {
        $currentUser = auth()->user();

        // Check authorization
        if (!$currentUser->hasAnyRole(['superadmin', 'admin']) && !$currentUser->can('update manajemenpengguna/users')) {
            $this->notifyError("Anda tidak memiliki izin untuk melakukan switch akun.");
            return redirect()->back();
        }

        // Prevent nested switch
        if (session()->has('impersonator_id')) {
            $this->notifyWarning("Anda sedang dalam mode switch akun. Silakan kembali ke akun utama terlebih dahulu sebelum beralih ke akun lain.");
            return redirect()->back();
        }

        $targetUser = User::findOrFail($id);

        if ($targetUser->id === $currentUser->id) {
            $this->notifyWarning("Anda sudah sedang login pada akun ini.");
            return redirect()->back();
        }

        if ($targetUser->status !== 'active') {
            $this->notifyError("Tidak dapat beralih ke akun yang berstatus tidak aktif atau belum disetujui.");
            return redirect()->back();
        }

        // Store original impersonator data in session
        session([
            'impersonator_id' => $currentUser->id,
            'impersonator_name' => $currentUser->name,
            'impersonator_role' => $currentUser->roles->pluck('name')->implode(', ') ?: 'Administrator',
        ]);

        // Login as target user
        Auth::loginUsingId($targetUser->id);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Berhasil beralih akun. Anda sekarang masuk sebagai \"{$targetUser->name}\".");

        return redirect()->route('dashboard');
    }

    /**
     * Leave impersonation and return to the original user account.
     */
    public function switchBack(Request $request)
    {
        if (!session()->has('impersonator_id')) {
            $this->notifyWarning("Tidak ada sesi switch akun yang aktif.");
            return redirect()->route('dashboard');
        }

        $impersonatorId = session()->pull('impersonator_id');
        session()->forget('impersonator_name');
        session()->forget('impersonator_role');

        $originalUser = User::find($impersonatorId);

        if (!$originalUser) {
            $this->notifyError("Akun utama tidak ditemukan.");
            return redirect()->route('login');
        }

        Auth::loginUsingId($originalUser->id);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Berhasil kembali ke akun utama \"{$originalUser->name}\".");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Bulk assign, append, or remove roles for selected users.
     */
    public function bulkAssignRole(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'action_mode' => 'required|in:sync,append,remove',
        ], [
            'user_ids.required' => 'Pilih minimal satu pengguna untuk diperbarui perannya.',
            'action_mode.required' => 'Pilih mode tindakan perubahan role.',
        ]);

        $userIds = $validated['user_ids'];
        $selectedRoles = $validated['roles'] ?? [];
        $mode = $validated['action_mode'];

        if (empty($selectedRoles) && $mode !== 'sync') {
            $this->notifyWarning('Pilih minimal satu peran (role) untuk mode ini.');
            return redirect()->back();
        }

        $users = User::whereIn('id', $userIds)->get();
        $updatedCount = 0;

        foreach ($users as $user) {
            if ($mode === 'sync') {
                $user->syncRoles($selectedRoles);
                $updatedCount++;
            } elseif ($mode === 'append') {
                if (!empty($selectedRoles)) {
                    $user->assignRole($selectedRoles);
                    $updatedCount++;
                }
            } elseif ($mode === 'remove') {
                foreach ($selectedRoles as $roleName) {
                    if ($user->hasRole($roleName)) {
                        $user->removeRole($roleName);
                    }
                }
                $updatedCount++;
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $actionText = match ($mode) {
            'sync' => 'disinkronisasi / diatur ulang',
            'append' => 'ditambahkan',
            'remove' => 'dicabut',
        };

        $this->notifySuccess("Peran (Role) berhasil {$actionText} untuk {$updatedCount} pengguna terpilih.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }
}
