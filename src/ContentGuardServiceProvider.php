<?php

namespace Heyitsmi\ContentGuard;

use Illuminate\Support\ServiceProvider;

class ContentGuardServiceProvider extends ServiceProvider
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
            __DIR__ . '/../config/content-guard.php', 'content-guard'
        );

        // Bind the main class to the service container.
        // We use a singleton if we want to load the dictionary only once per request.
        // For now, standard binding is fine.
        $this->app->bind('content-guard', function ($app) {
            return new ContentGuard();
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
            // Users can run: php artisan vendor:publish --tag="content-guard-config"
            $this->publishes([
                __DIR__ . '/../config/content-guard.php' => config_path('content-guard.php'),
            ], 'content-guard-config');
        }
    }
}