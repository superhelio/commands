<?php

namespace Superhelio\Commands;

use ReflectionClass;
use Superhelio\Commands\Commands\Reload;

class ReloadTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testbench']);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => 'reloadTest__',
        ]);
    }

    /**
     * Get package providers.
     * At a minimum this is the package being tested, but also
     * would include packages upon which our package depends.
     * In a normal app environment these would be added to
     * the 'providers' array in the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            '\Superhelio\Commands\Tests\Stubs\ServiceProvider',
            '\Superhelio\Commands\ServiceProvider'
        ];
    }

    public function test_reload_exists()
    {
        $this->assertTrue(class_exists(Reload::class));
        $reload = new Reload();

        $this->assertInstanceOf(Reload::class, $reload);
    }

    public function test_reload_has_required_methods_and_properties()
    {
        $reload = new Reload();
        $this->assertTrue(method_exists($reload, 'handle'), 'handle');
        $this->assertTrue(method_exists($reload, 'runReload'), 'runReload');
        $this->assertTrue(method_exists($reload, 'automate'), 'automate');

        $reload = new ReflectionClass(Reload::class);
        $this->assertTrue($reload->hasProperty('signature'), 'signature');
        $this->assertTrue($reload->hasProperty('description'), 'description');
    }
}
