<?php

namespace Heyitsmi\ContentGuard;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ContentGuardServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/content-guard.php', 'content-guard'
        );

        $this->app->singleton('content-guard', function ($app) {
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
        if ($this->app->runningInConsole()) {
            
            $this->publishes([
                __DIR__ . '/../config/content-guard.php' => config_path('content-guard.php'),
            ], 'content-guard-config');

            $this->publishes([
                __DIR__ . '/../resources/css' => public_path('vendor/content-guard/css'),
                __DIR__ . '/../resources/js' => public_path('vendor/content-guard/js'),
            ], 'content-guard-assets');
        }

        Blade::directive('contentGuardAssets', function () {
            return "<?php echo app('content-guard')->styles() . app('content-guard')->scripts(); ?>";
        });
    }
}