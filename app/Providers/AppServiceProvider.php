<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Hanya Role 'superadmin' yang memiliki akses bebas tanpa pengaturan
        Gate::before(function (User $user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });

        $configPath = config_path('sidenav-template');
        if (is_dir($configPath)) {
            foreach (glob($configPath . '/*.php') as $file) {
                $key = basename($file, '.php');
                config()->set("sidenav-template.{$key}", require $file);
            }
        }

        View::composer('layouts.partials.sidenav', \App\Http\ViewComposers\SidebarComposer::class);

        View::composer(['layouts.partials.title-meta', 'layouts.partials.sidenav', 'layouts.partials.footer'], function ($view) {
            if (class_exists(\App\Models\Admin\DukunganAplikasi\ProfilAplikasi::class)) {
                try {
                    $view->with('appProfil', \App\Models\Admin\DukunganAplikasi\ProfilAplikasi::getSettings());
                } catch (\Exception $e) {
                    $view->with('appProfil', null);
                }
            } else {
                $view->with('appProfil', null);
            }
        });

        View::composer(['layouts.partials.topbar', 'layouts.partials.sidenav'], function ($view) {
            if (class_exists(\App\Models\Admin\DukunganAplikasi\FiturAplikasi::class)) {
                try {
                    $view->with('appFeatures', \App\Models\Admin\DukunganAplikasi\FiturAplikasi::getSettings());
                } catch (\Exception $e) {
                    $view->with('appFeatures', null);
                }
            } else {
                $view->with('appFeatures', null);
            }
        });
    }
}
