<?php namespace NrmlCo\LaravelApiKeys;
use NrmlCo\LaravelApiKeys\ApiKey;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Str;
class ApiKeyToUserProvider implements UserProvider
{
    private $apiKey;
    private $user;
    public function __construct (User $user, ApiKey $apiKey) {
        $this->user = $user;
        $this->apiKey = $apiKey;
    }
    public function retrieveById ($identifier) {
        return $this->user->find($identifier);
    }
    public function retrieveByToken ($identifier, $apiKey) {
        $apiKey = $this->apiKey->with('user')->where($identifier, $apiKey)->first();
        if($apiKey){
            $apiKey->touch();
        }
        return $apiKey && $apiKey->user ? $apiKey->user : null;
    }
    public function updateRememberToken (Authenticatable $user, $token) {
        // update via remember token not necessary
    }
    public function retrieveByCredentials (array $credentials) {
        // implementation upto user.
        // how he wants to implement -
        // let's try to assume that the credentials ['username', 'password'] given
        $user = $this->user;
        $apiKey = $this->apiKey;
        foreach ($credentials as $credentialKey => $credentialValue) {
            if (!Str::contains($credentialKey, 'password')) {
                $apiKey->where($credentialKey, $credentialValue);
            }
        }
        $apiKey->first();
        return $apiKey->user;
    }
    public function validateCredentials (Authenticatable $user, array $credentials) {
        $plain = $credentials['password'];
        return app('hash')->check($plain, $user->getAuthPassword());
    }
}
