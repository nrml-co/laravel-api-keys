<?php

namespace NrmlCo\LaravelApiKeys;

trait HasApiKeys
{
    public function apiKeys(){
        return $this->hasMany(ApiKey::class);
    }
}
