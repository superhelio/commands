<?php

namespace Superhelio\Commands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Gozer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'superhelio:gozer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force delete database tables that have your table prefix';

    /**
     * @var string Database table prefix
     */
    private $dbPrefix = '';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        if (!class_exists('\\Doctrine\\DBAL\\Schema\\Schema')) {
            $this->error('You are missing doctrine/dbal, you should add it to your project:');
            $this->info('composer require doctrine/dbal');

            return false;
        }

        $this->info('

  ________
 /  _____/  ____________ ___________ 
/   \  ___ /  _ \___   // __ \_  __ \
\    \_\  (  <_> )    /\  ___/|  | \/
 \______  /\____/_____ \\___  >__|
        \/            \/    \/

');

        $this->setDatabasePrefix($this->getDatabasePrefix());

        $confirmationQuestion = 'Delete all of your database tables?';
        if (!empty($this->dbPrefix)) {
            $confirmationQuestion = sprintf(
                'Delete your tables that begin with %s*',
                $this->dbPrefix
            );
        }

        if ($this->confirm($confirmationQuestion)) {
            $connection = $this->getConnection();
            $tables = $this->getTables($connection);

            /**
             * Reject tables that do not have specified table prefix.
             * We would not want to destroy other tables that might
             * be in the same database, in "homestead" for example.
             *
             * @var \Illuminate\Support\Collection $tables
             */
            $tables = $this->getFilteredTables($tables);

            // Check that we got at least one table, bail out if not
            if ($tables->count() < 1) {
                $this->info('There are no tables, only Zuul.');

                return true;
            }

            /*
             * Bid your farewells to these tables.
             * Last look and confirmation.
             */
            $this->info(sprintf(
                "Tables found:\n - %s",
                implode(",\n - ", $tables->toArray())
            ));
            $this->line('');

            // Last confirmation before dropping tables
            if ($this->confirm('Really delete those tables?')) {
                /** Fancy pants progress bar to see your tables get destroyed */
                $bar = $this->output->createProgressBar($tables->count());

                Schema::disableForeignKeyConstraints();
                $tables->each(function ($table) use ($bar, $connection) {
                    // Drop the table
                    $connection->dropTable($table);

                    // Advance our progress bar
                    $bar->advance();
                });
                Schema::enableForeignKeyConstraints();

                // Progress bar is now finished
                $bar->finish();
            }

            $this->line('');
            $this->line('');
        }

        $this->info('Done.');

        return true;
    }

    /**
     * @return bool|\Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    public function getConnection()
    {
        try {
            // @var \Doctrine\DBAL\Schema\AbstractSchemaManager $connection
            return app('db')->connection()->getDoctrineSchemaManager();
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return false;
        }
    }

    /**
     * @return array|bool
     */
    public function getTables(\Doctrine\DBAL\Schema\AbstractSchemaManager $connection)
    {
        try {
            /** @var array $tables */
            $tables = $connection->listTableNames();
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return false;
        }

        return $tables;
    }

    public function getDatabasePrefix()
    {
        return trim(DB::connection()->getTablePrefix());
    }

    /**
     * This is mainly for testing purposes.
     *
     * @param string $prefix
     */
    public function setDatabasePrefix($prefix = '')
    {
        $this->dbPrefix = $prefix;
    }

    /**
     * @param array|\Illuminate\Support\Collection $tables
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFilteredTables($tables = [])
    {
        $prefix = $this->dbPrefix;

        return collect($tables)->reject(function ($table) use ($prefix) {
            return !Str::startsWith($table, $prefix);
        });
    }
}
