# Laravel Api Keys

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nrml-co/laravel-api-keys.svg?style=flat-square)](https://packagist.org/packages/nrml-co/laravel-api-keys)
[![Build Status](https://img.shields.io/travis/nrml-co/laravel-api-keys/master.svg?style=flat-square)](https://travis-ci.org/nrml-co/laravel-api-keys)
[![Quality Score](https://img.shields.io/scrutinizer/g/nrml-co/laravel-api-keys.svg?style=flat-square)](https://scrutinizer-ci.com/g/nrml-co/laravel-api-keys)
[![Total Downloads](https://img.shields.io/packagist/dt/nrml-co/laravel-api-keys.svg?style=flat-square)](https://packagist.org/packages/nrml-co/laravel-api-keys)

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

## Usage
Laravel 5.8 and above will register the service provider automatically
``` php
// Usage description here
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

If you discover any security related issues, please email ed@normalllc.com instead of using the issue tracker.

## Credits

- [Ed Anisko](https://github.com/nrml-co)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
