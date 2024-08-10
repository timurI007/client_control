<?php

namespace App\Providers;

use App\Services\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthService::class, function (Application $app) {
            return new AuthService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(AuthService $authService): void
    {
        View::composer('*', function ($view) use($authService) {
            $view->with('userFullName', $authService->getUserFullName());
        });
    }
}
