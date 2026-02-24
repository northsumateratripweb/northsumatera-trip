<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Events\QueryExecuted;

class PerformanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Log slow database queries (> 100ms)
        if (app()->environment('local', 'staging')) {
            DB::listen(function (QueryExecuted $query) {
                if ($query->time > 100) {
                    Log::warning('Slow query detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time . 'ms',
                    ]);
                }
            });
        }

        // Enable query log in development
        if (app()->environment('local')) {
            DB::enableQueryLog();
        }

        // Optimize for production
        if (app()->environment('production')) {
            // Disable debug mode
            config(['app.debug' => false]);
            
            // Set cache driver
            config(['cache.default' => 'database']);
        }
    }
}
