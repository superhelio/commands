<?php

namespace Superhelio\Commands\Tests;

use Superhelio\Commands\Commands\Reload;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReloadTest extends \Orchestra\Testbench\TestCase
{
    public function testReloadTest()
    {
        self::assertTrue(true);
    }

    public function test_reload_is_installed()
    {
        self::assertTrue(class_exists('\\Superhelio\\Commands\\Commands\\Reload'));
    }

    public function test_reload_has_required_methods_and_properties()
    {
        $reload = new \ReflectionClass('\\Superhelio\\Commands\\Commands\\Reload');
        self::assertTrue($reload->hasMethod('handle'));
        self::assertTrue($reload->hasProperty('signature'));
        self::assertTrue($reload->hasProperty('description'));
    }
}
