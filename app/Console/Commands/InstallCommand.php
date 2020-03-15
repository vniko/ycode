<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * This command install the application
     *
     * @var string
     */
    protected $description = 'Install application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Artisan::call('key:generate');
        $this->info('Key generated');

        \Artisan::call('migrate');
        $this->info('Migrations done');

        \Artisan::call('db:seed');
        $this->info('DB seeding done');
    }
}
