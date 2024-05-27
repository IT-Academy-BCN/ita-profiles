<?php

namespace App\Providers;

use Illuminate\Cache\CacheManager;
use Illuminate\Filesystem\Filesystem;
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
        // Registro de proveedores de servicios
        $this->app->singleton('files', function ($app) {
            return new Filesystem;
        });
        $this->app->singleton('cache', function ($app) {
            return new CacheManager($app);
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
