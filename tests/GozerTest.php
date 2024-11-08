<?php

namespace Superhelio\Commands\Tests;

use ReflectionClass;
use Superhelio\Commands\Commands\Gozer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/**
 * @internal
 * @coversNothing
 */
class GozerTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testbench']);
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => 'gozerTest__',
        ]);
    }

    /**
     * Get package providers.
     * At a minimum this is the package being tested, but also
     * would include packages upon which our package depends.
     * In a normal app environment these would be added to
     * the 'providers' array in the config/app.php file.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Superhelio\Commands\Tests\Stubs\ServiceProvider::class,
            \Superhelio\Commands\ServiceProvider::class,
        ];
    }

    public function testDatabaseIsThereAndFunctions()
    {
        DB::table('users')->insert([
            'name' => 'User name',
            'email' => 'hello@gozer.dev',
            'password' => bcrypt('123'),
        ]);

        $users = DB::table('users')->where('id', '=', 1)->first();
        self::assertEquals('hello@gozer.dev', $users->email);
        self::assertEquals('User name', $users->name);
        self::assertTrue(Hash::check('123', $users->password));
    }

    public function testDbalIsInstalled()
    {
        self::assertTrue(class_exists('\\Doctrine\\DBAL\\Schema\\Schema'));
    }

    public function testGozerIsInstalled()
    {
        self::assertTrue(class_exists('\\Superhelio\\Commands\\Commands\\Gozer'));
    }

    public function testGozerHasRequiredMethodsAndProperties()
    {
        $gozer = new ReflectionClass('\\Superhelio\\Commands\\Commands\\Gozer');
        self::assertTrue($gozer->hasMethod('handle'));
        self::assertTrue($gozer->hasProperty('signature'));
        self::assertTrue($gozer->hasProperty('description'));
        self::assertTrue($gozer->hasProperty('dbPrefix'));
    }

    public function testGozerFindsDatabasePrefix()
    {
        $gozer = new Gozer();

        self::assertEquals('gozerTest__', $gozer->getDatabasePrefix());
    }

    public function testGozerFindsUsersTable()
    {
        $gozer = new Gozer();

        $connection = $gozer->getConnection();

        $tables = $gozer->getTables($connection);
        self::assertContains('gozerTest__users', $tables);

        $gozer->setDatabasePrefix('gozerTest__');
        $filteredTables = $gozer->getFilteredTables($tables);
        self::assertTrue(is_a($filteredTables, \Illuminate\Support\Collection::class));
        self::assertContains('gozerTest__users', $filteredTables->toArray());
    }

    public function testGozerTableFilteringWorks()
    {
        $gozer = new Gozer();
        $tables = [
            'gozerTest__users',
            'gozerTest__migrations',
            'this_should_be_filtered',
            'filter_me_too',
        ];

        $gozer->setDatabasePrefix('gozerTest__');
        $filtered = $gozer->getFilteredTables($tables);
        $array = $filtered->toArray();

        self::assertNotContains('this_should_be_filtered', $array);
        self::assertNotContains('filter_me_too', $array);
        self::assertContains('gozerTest__users', $array);
        self::assertContains('gozerTest__migrations', $array);
    }
}
