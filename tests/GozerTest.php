<?php
namespace Superhelio\Commands;

use Superhelio\Commands\Commands\Gozer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GozerTest extends \Orchestra\Testbench\TestCase
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
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Superhelio\Commands\Tests\Stubs\ServiceProvider::class,
            \Superhelio\Commands\ServiceProvider::class
        ];
    }

    public function testGozerTest()
    {
        \DB::table('users')->insert([
            'name' => 'User name',
            'email' => 'hello@gozer.dev',
            'password' => bcrypt('123')
        ]);

        $users = \DB::table('users')->where('id', '=', 1)->first();
        $this->assertEquals('hello@gozer.dev', $users->email);
        $this->assertEquals('User name', $users->name);
        $this->assertTrue(\Hash::check('123', $users->password));
    }
}
