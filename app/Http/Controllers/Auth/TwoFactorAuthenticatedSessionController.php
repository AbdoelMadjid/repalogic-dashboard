<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\ManajemenPengguna\ActivityLog;
use App\Models\User;
use App\Services\Auth\TwoFactorAuthenticationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TwoFactorAuthenticatedSessionController extends Controller
{
    /**
     * Show the two-factor authentication challenge view.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get('login.id');
        $user = User::find($userId);

        if (!$user || !$user->hasEnabledTwoFactor()) {
            $request->session()->forget(['login.id', 'login.remember']);
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge', [
            'user' => $user,
        ]);
    }

    /**
     * Attempt to authenticate using the two-factor authentication code.
     */
    public function store(Request $request, TwoFactorAuthenticationService $service): RedirectResponse
    {
        if (!$request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get('login.id');
        $user = User::findOrFail($userId);

        $remember = $request->session()->get('login.remember', false);

        if ($code = $request->input('code')) {
            try {
                $secret = decrypt($user->two_factor_secret);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'code' => 'Kunci rahasia 2FA rusak. Silakan hubungi Administrator.',
                ]);
            }

            if (!$service->verify($secret, $code)) {
                throw ValidationException::withMessages([
                    'code' => 'Kode autentikasi 6-digit tidak valid atau telah kedaluwarsa.',
                ]);
            }
        } elseif ($recoveryCode = $request->input('recovery_code')) {
            if (!$user->replaceRecoveryCode($recoveryCode)) {
                throw ValidationException::withMessages([
                    'recovery_code' => 'Kode pemulihan cadangan tidak valid atau sudah pernah digunakan sebelumnya.',
                ]);
            }
        } else {
            throw ValidationException::withMessages([
                'code' => 'Silakan masukkan kode autentikasi 6-digit atau kode pemulihan cadangan.',
            ]);
        }

        Auth::login($user, $remember);

        $request->session()->forget(['login.id', 'login.remember']);
        $request->session()->regenerate();

        $user->recordLogin($request);

        ActivityLog::log(
            description: "Login berhasil dengan verifikasi Two-Factor Authentication (2FA TOTP)",
            subject: $user,
            event: 'login',
            properties: ['method' => $request->filled('code') ? 'totp_app' : 'recovery_code'],
            logName: 'auth'
        );

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
