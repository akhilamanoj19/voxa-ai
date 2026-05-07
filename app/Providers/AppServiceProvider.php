<?php

namespace App\Providers;

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
        // Unit II: Sharing Data with all Views
        view()->share('app_name', 'Laravel Learning Portal');
        view()->share('syllabus_version', '1.0');
    }
}
