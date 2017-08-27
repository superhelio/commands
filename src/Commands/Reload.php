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
    protected $signature = 'superhelio:reload';

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
        if ($this->confirm('Rollback all your database tables, recreate them and seed?')) {
            $this->call(
                'migrate:reset',
                [
                    '--no-interaction' => true,
                    '--env' => 'development',
                    '--verbose' => 3
                ]
            );
            $this->call(
                'migrate',
                [
                    '--seed' => true,
                    '--no-interaction' => true,
                    '--env' => 'development',
                    '--verbose' => 3
                ]
            );

            return true;
        }
    }
}
