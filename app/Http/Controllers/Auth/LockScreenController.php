<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LockScreenController extends Controller
{
    /**
     * Verify user password and unlock the screen.
     */
    public function unlock(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Password wajib diisi untuk membuka layar.',
        ]);

        $user = $request->user();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password yang Anda masukkan salah. Silakan periksa kembali.',
            ], 422);
        }

        // Simpan penanda bahwa sesi telah aktif kembali
        $request->session()->put('last_activity', time());

        return response()->json([
            'success' => true,
            'message' => 'Layar berhasil dibuka kembali.',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
