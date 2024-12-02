<?php

namespace Attargah\GogetSSL;

use Illuminate\Support\ServiceProvider;

class GogetSSLServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__.'/../config/gogetssl.php' => config_path('gogetssl.php'),
        ], 'gogetssl-config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/gogetssl.php', 'gogetssl');
        $this->app->singleton(GogetSSL::class, function ($app) {
            return new GogetSSL($app['config']['gogetssl']);
        });
    }

}
