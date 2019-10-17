<?php

namespace NrmlCo\LaravelApiKeys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use NrmlCo\LaravelApiKeys\LaravelApiKeyType;


class LaravelApiKeys
{
    public static function create(LaravelApiKeyType $apiKeyType = null)
    {
        if ($apiKeyType === null)
        {
            $apiKeyType = LaravelApiKeyType::SANDBOX;
        }

        return ApiKey::firstOrCreate([
            'user_id' => Auth::id(),
            'type' => $apiKeyType,
            'key' => Str::random(40)
        ]);
    }
}
