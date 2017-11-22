<?php

namespace Superhelio\Commands;

use ReflectionClass;

class PackageTest extends \Orchestra\Testbench\TestCase
{
    public function test_facade()
    {
        $facade = new ReflectionClass(Facade::class);
        $this->assertTrue($facade->hasMethod('getFacadeAccessor'));
        $this->assertTrue($facade->getMethod('getFacadeAccessor')->isProtected());
        $this->assertTrue($facade->getMethod('getFacadeAccessor')->isStatic());
    }

    public function test_service_provider()
    {
        $sp = new ReflectionClass(\Superhelio\Commands\ServiceProvider::class);
        $this->assertTrue($sp->hasMethod('register'));
        $this->assertTrue($sp->hasMethod('registerReloader'));
        $this->assertTrue($sp->hasMethod('registerGozer'));
    }
}
