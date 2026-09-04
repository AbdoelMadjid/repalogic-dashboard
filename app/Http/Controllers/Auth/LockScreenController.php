<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LockScreenController extends Controller
{
    /**
     * Verify user password and unlock the screen.
     * Supports unlocking both with active session and re-authenticating if the session expired during idle.
     */
    public function unlock(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
            'email' => ['nullable', 'email'],
        ], [
            'password.required' => 'Password wajib diisi untuk membuka layar.',
        ]);

        $user = $request->user();

        // Jika sesi telah expired saat idle, cari user berdasarkan email yang dikirim
        if (! $user && $request->filled('email')) {
            $user = User::where('email', $request->email)->first();
        }

        if (! $user) {
            return response()->json([
                'success' => false,
                'session_expired' => true,
                'message' => 'Sesi Anda telah kedaluwarsa. Silakan login kembali.',
                'redirect' => route('login'),
            ], 401);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak aktif atau sedang dinonaktifkan oleh Administrator.',
            ], 403);
        }

        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password yang Anda masukkan salah. Silakan periksa kembali.',
            ], 422);
        }

        // Login atau segarkan sesi pengguna & token
        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('last_activity', time());

        return response()->json([
            'success' => true,
            'message' => 'Layar berhasil dibuka kembali.',
            'csrf_token' => csrf_token(),
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
