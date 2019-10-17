<?php

namespace NrmlCo\LaravelApiKeys;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Cache;

class LaravelApiKeysGuard implements Guard
{
    protected $api_user = null;

    public function __construct()
    {
        $xApiKey = request()->header('x-api-key');

        $apiKey = Cache::get($xApiKey, function() use ($xApiKey){
            $apiKey = ApiKey::where('key', $xApiKey)->first();
            Cache::put($xApiKey, $apiKey, now()->addMinutes(2));
            return $apiKey;
        }) ;

        if($apiKey)
        {
            $this->api_user = $apiKey->user;
        }


    }

    protected $rules = [

    ];

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return ! is_null($this->api_user);
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return false;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return $this->api_user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        return $this->api_user->id;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return ! is_null($this->api_user);
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->api_user = $user;
    }

}
