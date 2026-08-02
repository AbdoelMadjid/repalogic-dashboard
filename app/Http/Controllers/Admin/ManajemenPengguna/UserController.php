<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManajemenPengguna\UserRequest;
use App\Models\User;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $users = User::with('roles')->latest()->get();
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

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
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
     * Remove the specified user account.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            $this->notifyError("Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.");
            return redirect()->route('admin.manajemenpengguna.users.index');
        }

        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Pengguna \"{$user->name}\" berhasil dihapus.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }
}
