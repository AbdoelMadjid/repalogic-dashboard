<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'lock-screen/unlock',
            'logout',
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\CheckMaintenanceMode::class,
            \App\Http\Middleware\TrackUserActivity::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson() || $request->ajax()
        );

        $exceptions->render(function (\Throwable $e, Request $request) {
            $is419 = ($e instanceof TokenMismatchException)
                || ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $e->getStatusCode() === 419);

            if (! $is419) {
                return null;
            }

            if ($request->expectsJson() || $request->ajax() || $request->is('lock-screen/*') || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'session_expired' => true,
                    'message' => 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman atau login kembali.',
                    'redirect' => route('login'),
                ], 419);
            }

            if ($request->is('logout')) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('info_message', 'Sesi Anda telah diakhiri.');
            }

            // If user submitted a POST form (e.g. login) with stale token, redirect back gracefully to login with fresh token
            return redirect()->route('login')
                ->with('error_message', 'Sesi keamanan formulir Anda telah diperbarui. Silakan masukkan kata sandi Anda kembali.');
        });
    })->create();
