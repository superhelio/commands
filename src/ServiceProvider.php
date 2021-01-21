<?php

namespace Superhelio\Commands;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class PackageServiceProvider
 *
 * @package Superhelio\Commands
 * @see http://laravel.com/docs/master/packages#service-providers
 * @see http://laravel.com/docs/master/providers
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @see http://laravel.com/docs/master/providers#deferred-providers
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @see http://laravel.com/docs/master/providers#the-register-method
     * @return void
     */
    public function register()
    {
        $this->registerReloader();
        $this->registerGozer();
    }

    private function registerReloader()
    {
        $this->app->singleton('command.superhelio.reload', function ($app) {
            return $app[\Superhelio\Commands\Commands\Reload::class];
        });
        $this->commands('command.superhelio.reload');
    }

    private function registerGozer()
    {
        $this->app->singleton('command.superhelio.gozer', function ($app) {
            return $app[\Superhelio\Commands\Commands\Gozer::class];
        });
        $this->commands('command.superhelio.gozer');
    }
}
