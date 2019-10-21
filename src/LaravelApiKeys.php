<?php

namespace NrmlCo\LaravelApiKeys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use NrmlCo\LaravelApiKeys\ApiKeyType;


class LaravelApiKeys
{
    public static function create( $apiKeyType = null)
    {
        if ($apiKeyType === null)
        {
            $apiKeyType = ApiKeyType::SANDBOX;
        }

        return ApiKey::firstOrCreate([
            'user_id' => Auth::id(),
            'type' => $apiKeyType,
            'api_key' => Str::random(40)
        ]);
    }

    public static function register()
    {
        auth()->extend('api_key', function ($app, $name, array $config) {

            // automatically build the DI, put it as reference
            $userProvider = app(ApiKeyToUserProvider::class);
            $request = app('request');
            return new ApiKeyGuard($userProvider, $request, $config);
        });
    }
}
