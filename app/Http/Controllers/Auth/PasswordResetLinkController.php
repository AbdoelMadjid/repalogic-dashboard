<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset request for administrator processing.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (! $user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak terdaftar di sistem.']);
        }

        // Tandai bahwa pengguna mengajukan permintaan reset password ke administrator
        $user->update([
            'password_reset_requested_at' => now(),
        ]);

        return redirect()->route('login')->with(
            'reset_requested',
            'Permintaan reset password berhasil diajukan! Silakan menunggu proses reset kata sandi dari Administrator.'
        );
    }
}
