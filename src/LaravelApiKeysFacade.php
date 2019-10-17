<?php

namespace NrmlCo\LaravelApiKeys;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NrmlCo\LaravelApiKeys\Skeleton\SkeletonClass
 */
class LaravelApiKeysFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-api-keys';
    }
}
