<?php

namespace Superhelio\Commands\Tests;

/**
 * @internal
 * @coversNothing
 */
class ReloadTest extends \Orchestra\Testbench\TestCase
{
    public function testReloadTest()
    {
        self::assertTrue(true);
    }

    public function testReloadIsInstalled()
    {
        self::assertTrue(class_exists('\\Superhelio\\Commands\\Commands\\Reload'));
    }

    public function testReloadHasRequiredMethodsAndProperties()
    {
        $reload = new \ReflectionClass('\\Superhelio\\Commands\\Commands\\Reload');
        self::assertTrue($reload->hasMethod('handle'));
        self::assertTrue($reload->hasProperty('signature'));
        self::assertTrue($reload->hasProperty('description'));
    }
}
