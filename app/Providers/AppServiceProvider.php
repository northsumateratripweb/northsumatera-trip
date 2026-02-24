<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\TourRepositoryInterface::class,
            \App\Repositories\TourRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\CarRepositoryInterface::class,
            \App\Repositories\CarRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Livewire\Livewire::component('app.filament.pages.auth.custom-login', \App\Filament\Pages\Auth\CustomLogin::class);

        // Set application locale from session or browser preference
        try {
            $locale = Session::get('locale');
            
            if (!$locale && !app()->runningInConsole()) {
                $browserLocale = request()->getPreferredLanguage(['id', 'en', 'ms']);
                if ($browserLocale) {
                    $locale = $browserLocale;
                    Session::put('locale', $locale);
                }
            }

            if ($locale) {
                App::setLocale($locale);
            }
        } catch (\Throwable $e) {
            // ignore during early bootstrap or CLI
        }
    }
}
