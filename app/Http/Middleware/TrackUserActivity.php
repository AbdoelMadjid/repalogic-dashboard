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

            // 1. Simpan tanda online di cache dengan TTL 3 menit
            // Kunci ini dipakai untuk mengecek apakah user sedang online
            Cache::put('user-online-' . $userId, true, now()->addMinutes(3));

            // 2. Simpan timestamp ISO waktu aktivitas terakhir di cache (disimpan 30 hari)
            Cache::put('user-last-seen-' . $userId, now()->toIso8601String(), now()->addDays(30));

            // 3. Catat di daftar ID user yang sedang online
            $onlineList = Cache::get('online-users-list', []);
            if (!in_array($userId, $onlineList)) {
                $onlineList[] = $userId;
                Cache::put('online-users-list', $onlineList, now()->addMinutes(3));
            }
        }

        return $next($request);
    }
}
