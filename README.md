# Laravel Commands by [SuperHelio][link-author]

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This is a collection of Laravel Artisan commands created to help everyone
in their development work. We try to keep these as useful as possible.

This package requires PHP 7.3 or later. The `composer.lock` file has been generated with PHP v7.4.13.

## Install

### Step 1: Install Through Composer

```bash
$ composer require superhelio/commands --dev
```

### Step 2: Add the Service Provider

You'll only want to use these generators for local development, so you don't want to update the production `providers` array in `config/app.php`. Instead, add the provider in `app/Providers/AppServiceProvider.php`, like so:

```php
public function register()
{
    if ($this->app->environment() === 'local') {
        $this->app->register('SuperHelio\Commands\ServiceProvider');
    }
}
```

## Usage

- _superhelio:gozer_
  - Force delete database tables that have your table prefix
  - `php artisan superhelio:gozer`
- _superhelio:reload_
  - Reset database, migrate and seed
  - `php artisan superhelio:reload`

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
$ composer test
```

## Security

If you discover any security related issues, please contact [SuperHelio](link-author).

## Credits

- [SuperHelio][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/superhelio/commands.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/superhelio/commands.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/superhelio/commands
[link-downloads]: https://packagist.org/packages/superhelio/commands
[link-author]: https://github.com/superhelio
[link-contributors]: https://github.com/superhelio/commands/graphs/contributors
[link-dbal]: https://packagist.org/packages/doctrine/dbal
