<?php

namespace App\Providers;

use App\Service\Project\ProcessedProjectsService;
use Illuminate\Cache\CacheManager;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Forzar HTTPS en Laravel
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Registro de proveedores de servicios
        $this->app->singleton('files', function ($app) {
            return new Filesystem;
        });
        $this->app->singleton('cache', function ($app) {
            return new CacheManager($app);
        });
        $this->app->singleton(ProcessedProjectsService::class, function ($app) {
            return new ProcessedProjectsService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
