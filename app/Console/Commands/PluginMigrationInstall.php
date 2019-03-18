<?php

namespace Omega\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\InstallCommand;
use Omega\Utils\Plugin\Migrate\MigrationRepository;

class PluginMigrationInstall extends InstallCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'omega:plugin:migrate:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the migration repository';


    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationRepositoryInterface  $repository
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new MigrationRepository(resolve('db')));
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->repository->createRepository();

        $this->info('Migration table created successfully.');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
