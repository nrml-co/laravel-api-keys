<?php

namespace NrmlCo\LaravelApiKeys;

use Illuminate\Support\ServiceProvider;


class LaravelApiKeysServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-api-keys.php'),
            ], 'config');

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-api-keys');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-api-keys', function () {
            return new LaravelApiKeys();
        });

        $this->app->resolving('auth', function ($auth) {
            $auth->extend('lak', function($app, $name, array $config){
                return $app->make(LaravelApiKeysGuard::class,[
                    'name' => $name,
                    'config' => $config,
                    'provider' => $app['auth']->createUserProvider($config['provider'] ?? null)
                ]);
            });


        });
    }
}
