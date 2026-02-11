<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
        // Set application locale from session if available
        try {
            $locale = Session::get('locale', config('app.locale'));
            if ($locale) {
                App::setLocale($locale);
            }
        } catch (\Throwable $e) {
            // ignore during early bootstrap or CLI
        }
    }
}
