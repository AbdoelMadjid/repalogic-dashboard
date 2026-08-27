<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AccountReactivationController extends Controller
{
    /**
     * Display the account reactivation request form view.
     */
    public function create(): View
    {
        return view('auth.request-activation');
    }

    /**
     * Handle incoming account reactivation request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'reason' => ['nullable', 'string', 'max:500'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Alamat email tidak ditemukan dalam sistem kami.'],
            ]);
        }

        if ($user->status === 'active') {
            return redirect()->route('login')->with('info_message', 'Akun Anda sudah berstatus AKTIF. Silakan langsung masuk dengan email dan kata sandi Anda.');
        }

        if ($user->status === 'pending') {
            return redirect()->route('login')->with('registered_pending', 'Akun Anda saat ini masih dalam antrean persetujuan pendaftaran mandiri oleh Administrator.');
        }

        // User is inactive, update reactivation request timestamp & reason
        $user->update([
            'reactivation_requested_at' => now(),
            'reactivation_reason' => $request->input('reason'),
        ]);

        return redirect()->route('login')->with('reactivation_success', 'Permohonan aktivasi akun berhasil dikirimkan ke Administrator. Mohon menunggu proses verifikasi dan aktivasi kembali.');
    }
}
