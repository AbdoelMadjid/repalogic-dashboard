<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    /**
     * Handle an incoming request and track authenticated user online presence.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;

            // 1. Zero-Trust Account Status Check
            // Jika akun dinonaktifkan, ditolak, atau berstatus pending saat user masih membuka dashboard,
            // langsung logout paksa dan hancurkan sesi saat itu juga.
            if ($user->status !== 'active') {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                Cache::forget('user-online-' . $userId);
                $onlineList = Cache::get('online-users-list', []);
                if (in_array($userId, $onlineList)) {
                    $onlineList = array_values(array_diff($onlineList, [$userId]));
                    Cache::put('online-users-list', $onlineList, now()->addMinutes(3));
                }

                $inactiveMessage = match ($user->status) {
                    'inactive' => 'Akun Anda telah dinonaktifkan oleh Administrator. Sesi Anda telah diakhiri.',
                    'pending' => 'Akun Anda sedang menunggu persetujuan dari Administrator.',
                    'rejected' => 'Pendaftaran akun Anda telah ditolak oleh Administrator.',
                    default => 'Akun Anda tidak aktif. Sesi Anda telah diakhiri.'
                };

                $errorKey = match ($user->status) {
                    'inactive' => 'inactive',
                    'rejected' => 'rejected',
                    'pending' => 'unapproved',
                    default => 'inactive'
                };

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'message' => $inactiveMessage,
                        'redirect' => route('login')
                    ], 401);
                }

                return redirect()->route('login')
                    ->withErrors([$errorKey => $inactiveMessage])
                    ->with('error_message', $inactiveMessage);
            }

            // 2. Simpan tanda online di cache dengan TTL 3 menit
            // Kunci ini dipakai untuk mengecek apakah user sedang online
            Cache::put('user-online-' . $userId, true, now()->addMinutes(3));

            // 3. Simpan timestamp ISO waktu aktivitas terakhir di cache (disimpan 30 hari)
            Cache::put('user-last-seen-' . $userId, now()->toIso8601String(), now()->addDays(30));

            // 4. Catat di daftar ID user yang sedang online
            $onlineList = Cache::get('online-users-list', []);
            if (!in_array($userId, $onlineList)) {
                $onlineList[] = $userId;
                Cache::put('online-users-list', $onlineList, now()->addMinutes(3));
            }
        }

        return $next($request);
    }
}
