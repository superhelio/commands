<?php

namespace Superhelio\Commands\Tests\Stubs;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/migrations');
    }
}
