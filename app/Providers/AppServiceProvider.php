<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::before(function (User $user, $ability) {
            return $user->hasRole('master') ? true : null;
        });

        $configPath = config_path('sidenav-template');
        if (is_dir($configPath)) {
            foreach (glob($configPath.'/*.php') as $file) {
                $key = basename($file, '.php');
                config()->set("sidenav-template.{$key}", require $file);
            }
        }
    }
}
