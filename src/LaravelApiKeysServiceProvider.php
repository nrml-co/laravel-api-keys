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
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('laravel-api-keys', function () {
            return new LaravelApiKeys();
        });

        auth()->extend('api_key', function ($app, $name, array $config) {

            // automatically build the DI, put it as reference
            $userProvider = app(ApiKeyToUserProvider::class);
            $request = app('request');

            return new ApiKeyGuard($userProvider, $request, $config);
        });
    }
}
