<?php

namespace NrmlCo\LaravelApiKeys;

use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class ApiKeyGuard implements Guard
{
    use GuardHelpers;
    private $inputKey = '';
    private $storageKey = '';
    private $request;

    public function __construct(UserProvider $provider, Request $request, $configuration)
    {
        $this->provider = $provider;
        $this->request = $request;
        // key to check in request
        $this->inputKey = isset($configuration['input_key']) ? $configuration['input_key'] : 'x-api-key';
        // key to check in database
        $this->storageKey = isset($configuration['storage_key']) ? $configuration['storage_key'] : 'api_key';
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }
        $user = null;
        $apiKey = $this->getApiKeyForRequest();
        if (! empty($apiKey)) {
            // the token was found, how you want to pass?
            $user = $this->provider->retrieveByToken($this->storageKey, $apiKey);
        }

        return $this->user = $user;
    }

    /**
     * Get the apikey for the current request.
     * @return string
     */
    public function getApiKeyForRequest()
    {
        $apiKey = $this->request->header($this->inputKey);
        if (empty($apiKey)) {
            $apiKey = $this->request->query($this->inputKey);
        }
        if (empty($apiKey)) {
            $apiKey = $this->request->input($this->inputKey);
        }
        if (empty($apiKey)) {
            $apiKey = $this->request->bearerToken();
        }

        return $apiKey;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials[$this->inputKey])) {
            return false;
        }
        $credentials = [$this->storageKey => $credentials[$this->inputKey]];
        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }
    }
}
