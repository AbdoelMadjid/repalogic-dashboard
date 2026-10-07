<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ManajemenPengguna\ActivityLog;
use App\Services\Auth\TwoFactorAuthenticationService;
use App\Traits\HasNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TwoFactorSecurityController extends Controller
{
    use HasNotification;

    /**
     * Start the 2FA enablement process: generate secret and QR code.
     */
    public function enable(Request $request, TwoFactorAuthenticationService $service): JsonResponse
    {
        $user = Auth::user();

        if ($user->hasEnabledTwoFactor()) {
            return response()->json([
                'success' => false,
                'message' => 'Two-Factor Authentication sudah aktif pada akun Anda.',
            ], 400);
        }

        $secret = $service->generateSecretKey(16);
        $user->forceFill([
            'two_factor_secret' => encrypt($secret),
            'two_factor_confirmed_at' => null,
        ])->save();

        $appName = config('app.name', 'REPALOGIC Dashboard');
        $qrCodeUrl = $service->getQrCodeUrl($appName, $user->email, $secret);
        $svgQrCode = $service->getQrCodeSvg($qrCodeUrl, 200);

        // Format secret key with spaces for readability (e.g. ABCD EFGH IJKL MNOP)
        $formattedSecret = chunk_split($secret, 4, ' ');

        return response()->json([
            'success' => true,
            'svg' => $svgQrCode,
            'secret' => trim($formattedSecret),
            'raw_secret' => $secret,
            'qr_code_url' => $qrCodeUrl,
        ]);
    }

    /**
     * Confirm 2FA enablement by verifying a 6-digit TOTP code.
     */
    public function confirm(Request $request, TwoFactorAuthenticationService $service): JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string'],
        ], [
            'code.required' => 'Kode autentikasi 6-digit wajib diisi.',
        ]);

        $user = Auth::user();

        if (empty($user->two_factor_secret)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan mulai proses aktivasi 2FA terlebih dahulu.',
            ], 400);
        }

        try {
            $secret = decrypt($user->two_factor_secret);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kunci rahasia 2FA tidak valid atau rusak.',
            ], 400);
        }

        if (!$service->verify($secret, $request->code)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode autentikasi 6-digit tidak valid atau telah kedaluwarsa. Pastikan jam pada perangkat Anda sinkron.',
            ], 422);
        }

        $recoveryCodes = $service->generateRecoveryCodes(8);

        $user->forceFill([
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ])->save();

        ActivityLog::log(
            description: "Mengaktifkan Two-Factor Authentication (2FA TOTP)",
            subject: $user,
            event: 'updated',
            properties: ['status' => 'enabled'],
            logName: 'user'
        );

        return response()->json([
            'success' => true,
            'message' => 'Two-Factor Authentication (2FA) berhasil diaktifkan.',
            'recovery_codes' => $recoveryCodes,
        ]);
    }

    /**
     * Disable 2FA with current password confirmation.
     */
    public function disable(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Kata sandi saat ini wajib diisi untuk konfirmasi keamanan.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi yang Anda masukkan salah.',
            ], 422);
        }

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        ActivityLog::log(
            description: "Menonaktifkan Two-Factor Authentication (2FA TOTP)",
            subject: $user,
            event: 'updated',
            properties: ['status' => 'disabled'],
            logName: 'user'
        );

        return response()->json([
            'success' => true,
            'message' => 'Two-Factor Authentication (2FA) berhasil dinonaktifkan.',
        ]);
    }

    /**
     * Get active recovery codes.
     */
    public function getRecoveryCodes(Request $request): JsonResponse
    {
        $user = Auth::user();

        if (!$user->hasEnabledTwoFactor()) {
            return response()->json([
                'success' => false,
                'message' => 'Two-Factor Authentication belum diaktifkan.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'recovery_codes' => $user->recoveryCodes(),
        ]);
    }

    /**
     * Regenerate new recovery codes.
     */
    public function regenerateRecoveryCodes(Request $request, TwoFactorAuthenticationService $service): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Kata sandi saat ini wajib diisi untuk membuat ulang kode pemulihan.',
        ]);

        $user = Auth::user();

        if (!$user->hasEnabledTwoFactor()) {
            return response()->json([
                'success' => false,
                'message' => 'Two-Factor Authentication belum diaktifkan.',
            ], 400);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi yang Anda masukkan salah.',
            ], 422);
        }

        $recoveryCodes = $service->generateRecoveryCodes(8);

        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ])->save();

        ActivityLog::log(
            description: "Memperbarui Kode Pemulihan Cadangan 2FA (Regenerate Recovery Codes)",
            subject: $user,
            event: 'updated',
            properties: ['recovery_codes_count' => count($recoveryCodes)],
            logName: 'user'
        );

        return response()->json([
            'success' => true,
            'message' => 'Kode pemulihan cadangan 2FA berhasil diperbarui.',
            'recovery_codes' => $recoveryCodes,
        ]);
    }
}
