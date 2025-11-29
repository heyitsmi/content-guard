<?php

namespace Heyitsmi\IndoGuard;

use Illuminate\Support\ServiceProvider;

class IndoGuardServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge the package configuration file with the application's copy.
        // This allows users to define only the keys they want to override.
        $this->mergeConfigFrom(
            __DIR__ . '/../config/indo-guard.php', 'indo-guard'
        );

        // Bind the main class to the service container.
        // We use a singleton if we want to load the dictionary only once per request.
        // For now, standard binding is fine.
        $this->app->bind('indo-guard', function ($app) {
            return new IndoGuard();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Verification: Check if the application is running in the console.
        if ($this->app->runningInConsole()) {
            
            // Publish the configuration file to the user's config directory.
            // Users can run: php artisan vendor:publish --tag="indo-guard-config"
            $this->publishes([
                __DIR__ . '/../config/indo-guard.php' => config_path('indo-guard.php'),
            ], 'indo-guard-config');
        }
    }
}