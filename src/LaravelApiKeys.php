<?php

namespace NrmlCo\LaravelApiKeys;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LaravelApiKeys
{
    public static function create($apiKeyType = null, $data = [])
    {
        if ($apiKeyType === null) {
            $apiKeyType = ApiKeyType::SANDBOX;
        }

        $name = isset($data['name']) ? $data['name'] : 'Unnamed Key';

        return ApiKey::firstOrCreate([
            'user_id' => Auth::id(),
            'type' => $apiKeyType,
            'api_key' => Str::random(60),
            'name' => $name,
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
