<?php

namespace Superhelio\Commands\Commands;

use Illuminate\Console\Command;

class Reload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'superhelio:reload
        {--automate=false : Should run without questions?}
        {--loud=true : Should output reset and migrate outputs?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback migrations, migrate and run seeds';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $automated = $this->automate();

        if ($automated && $this->confirm('Rollback all your database tables, recreate them and seed?')) {
            return $this->runReload();
        }
        if (!$automated) {
            return $this->runReload();
        }
    }

    public function automate()
    {
        $automate = $this->option('automate');

        return !($automate === '1' || $automate === 1 || $automate === 'yes' || $automate === 'true');
    }

    public function outputVerbosity()
    {
        $output = $this->option('loud');

        return ($output === '1' || $output === 1 || $output == 'yes' || $output == 'true');
    }

    public function runReload()
    {
        $verbose = ($this->outputVerbosity() ? 3 : 0);
        $this->call(
            'migrate:reset',
            [
                '--no-interaction' => true,
                '--env' => 'development',
                '--verbose' => $verbose
            ]
        );
        $this->call(
            'migrate',
            [
                '--seed' => true,
                '--no-interaction' => true,
                '--env' => 'development',
                '--verbose' => $verbose
            ]
        );

        return true;
    }
}
