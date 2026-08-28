<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Hapus record pendaftaran lama yang berstatus 'rejected' agar calon pengguna dapat mendaftar ulang
        if ($request->filled('email')) {
            $existingRejectedUser = User::where('email', strtolower(trim($request->email)))
                ->where('status', 'rejected')
                ->first();

            if ($existingRejectedUser) {
                $existingRejectedUser->roles()->detach();
                $existingRejectedUser->delete();
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'terms' => ['accepted'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'terms.accepted' => 'Anda wajib menyetujui syarat & ketentuan.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('registered_pending', 'Pendaftaran berhasil! Akun Anda telah terdaftar dan sedang menunggu persetujuan dari Administrator sebelum dapat digunakan.');
    }
}
