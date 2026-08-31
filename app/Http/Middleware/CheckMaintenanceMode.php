<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isMaintenance = (bool) Cache::get('app_setting_maintenance_mode', false);

        if (! $isMaintenance) {
            return $next($request);
        }

        // Bypass untuk rute otentikasi login, logout, dan file statis/assets
        if ($request->is('login', 'logout', 'up', 'assets/*', 'storage/*', 'favicon.ico')) {
            return $next($request);
        }

        // Jika pengguna sudah login, cek apakah memiliki role superadmin atau admin
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('superadmin') || $user->hasRole('admin')) {
                return $next($request);
            }
        }

        $message = Cache::get('app_setting_maintenance_message', 'Sistem sedang dalam proses pemeliharaan berkala. Silakan coba beberapa saat lagi.');

        // Jika request AJAX atau API / JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'maintenance' => true,
            ], 503);
        }

        // Tampilkan view 503 Maintenance
        return response()->view('errors.503', [
            'message' => $message,
        ], 503);
    }
}
