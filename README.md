# Laravel Api Keys

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nrml-co/laravel-api-keys.svg?style=flat-square)](https://packagist.org/packages/nrml-co/laravel-api-keys)
[![Build Status](https://img.shields.io/travis/nrml-co/laravel-api-keys/master.svg?style=flat-square)](https://travis-ci.org/nrml-co/laravel-api-keys)
[![Total Downloads](https://img.shields.io/packagist/dt/nrml-co/laravel-api-keys.svg?style=flat-square)](https://packagist.org/packages/nrml-co/laravel-api-keys)
<!--
[![Quality Score](https://img.shields.io/scrutinizer/g/nrml-co/laravel-api-keys.svg?style=flat-square)](https://scrutinizer-ci.com/g/nrml-co/laravel-api-keys)
-->


This package offers a different type on API key system for Laravel.  The other options are either too simple or too complex.

Laravel ships with a guard that will allow you to create an access_token field in your user migration.  This allows easy
access to the api routes.

This package offers:
- multiple keys per user
- sandbox and production keys
- scopes

Laravel/Passport is a the full on oauth implementation.  This is a little more simple.     

## Installation

You can install the package via composer:

```bash
composer require nrml-co/laravel-api-keys
php artisan migrate
```
Laravel 5.8 and above will register the service provider automatically.

## Usage - Creating Keys
First add the HasApiKeys trait to the User model that ships with Laravel.
```php
use NrmlCo\LaravelApiKeys\HasApiKeys;


/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasApiKeys;

```

Next create a User. Easiest to to this part in tinker.  
``` php
$user = User::create([
        'name' => 'Ed Anisko',
        'email' => 'ed@nrml.co',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10)
        ]);
```

The user needs to be logged in.  Programmatically it looks like this.  
``` php
Auth::setUser($user);
```

Now the package will create ApiKeys for the authorized user.   
``` php
LaravelApiKeys::create(); // default is SANDBOX
```
Copy the new api key.


## Using the your API Keys
Add the new entry to the guards section of config/auth.php
``` php
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        "api_key" => [
            'driver' => 'api_key'
        ]

    ]
```


Use the 'auth:api_key' middleware in api.php routes.
``` php
Route::middleware('auth:api_key')->get('/user', function (Request $request) {
    return $request->user();
});
```

Replace the x-api-key header with your own api-key and test.
Use the header Accept: application/json.
``` bash

$ curl -X GET \
  http://homestead.test/api/user \
  -H 'Accept: application/json' \
  -H 'x-api-key: al4PA8V5jSuq4oFJOxK6lS4CeZEkDFtayBObJTHJ'

```
The above curl command will return the user authorized by the ApiKey.
```json
{
    "id": 1,
    "name": "Ed Anisko",
    "email": "ed@nrml.co",    
    "created_at": "2019-10-17 07:18:59",
    "updated_at": "2019-10-17 07:18:59"
}
```
### Testing

``` bash
phpunit 
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security
.

If you discover any security related issues, please email ed@normalllc.com instead of using the issue tracker.

## Credits

- [Ed Anisko](https://github.com/nrml-co)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
