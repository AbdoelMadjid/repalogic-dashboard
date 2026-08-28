<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManajemenPengguna\UserRequest;
use App\Models\User;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
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

        // Kirim pesan ke tabel messages & notifikasi
        try {
            \App\Models\Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $user->id,
                'subject' => 'Permohonan Non Aktif Akun',
                'body' => 'Permohonan non aktif akun Anda ditolak oleh Administrator.',
                'reason' => $reason,
                'message_type' => 'deactivation_rejected',
                'is_read' => false,
            ]);

            $user->notifications()->create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'type' => 'deactivation_rejected',
                'data' => [
                    'title' => 'Permohonan Non Aktif Akun',
                    'subtitle' => 'Permohonan non aktif akun Anda ditolak oleh Administrator.',
                    'message' => 'Permohonan non aktif akun Anda ditolak oleh Administrator.',
                    'reason' => $reason,
                    'icon' => 'ti ti-user-x',
                    'badge_class' => 'bg-danger-subtle text-danger border-danger-subtle',
                    'badge_label' => 'Penonaktifan Ditolak',
                    'url' => 'javascript:void(0);',
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
}
