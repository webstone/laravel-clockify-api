<?php

namespace Sourceboat\LaravelClockifyApi;

use Illuminate\Support\ServiceProvider;

class LaravelClockifyApiServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/clockify.php' => config_path('clockify.php'),
        ], 'clockify-config');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/clockify.php', 'clockify');
    }

}
