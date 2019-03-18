<?php

namespace Omega\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Omega\Utils\Plugin\Migrate\Command\PluginMigration;
use Omega\Utils\Plugin\Migrate\Migrator;

class PluginMigrate extends MigrateCommand
{
    use PluginMigration;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omega:plugin:migrate {name : The name of the plugin}
                {--force : Force the operation to run when in production.}
                {--step : Force the migrations to be run so they can be rolled back individually.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the database migrations for the given plugin';


    /**
     * The migrator instance.
     *
     * @var Migrator
     */
    protected $migrator;

    /**
     * Create a new migration command instance.
     *
     * @param  \Illuminate\Database\Migrations\Migrator  $migrator
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new Migrator());
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->migrator->setPluginName($this->getPluginName());

        $this->prepareDatabase();

        // Next, we will check to see if a path option has been defined. If it has
        // we will use the path relative to the root of this installation folder
        // so that migrations may be run for any path within the applications.
        $this->migrator->run($this->getMigrationPaths(), [
            'step' => $this->option('step'),
        ]);

        // Once the migrator has run we will grab the note output and send it out to
        // the console screen, since the migrator itself functions without having
        // any instances of the OutputInterface contract passed into the class.
        foreach ($this->migrator->getNotes() as $note) {
            $this->output->writeln($note);
        }
    }

    protected function prepareDatabase()
    {
    }
}
