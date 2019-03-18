<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.03.19
 * Time: 11:37
 */

namespace Omega\Console\Commands;


use Illuminate\Database\Console\Migrations\RollbackCommand;
use Omega\Utils\Plugin\Migrate\Command\PluginMigration;
use Omega\Utils\Plugin\Migrate\Migrator;
use Symfony\Component\Console\Input\InputOption;

class PluginMigrateRollback extends RollbackCommand
{
    use PluginMigration;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'omega:plugin:migrate:rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the last database migration for the given plugin';

    /**
     * The migrator instance.
     *
     * @var Migrator
     */
    protected $migrator;

    /**
     * Create a new migration rollback command instance.
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
     * @return void
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->migrator->setPluginName($this->getPluginName());

        $this->migrator->rollback(
            $this->getMigrationPaths(), [
                'step' => (int) $this->option('step'),
            ]
        );

        // Once the migrator has run we will grab the note output and send it out to
        // the console screen, since the migrator itself functions without having
        // any instances of the OutputInterface contract passed into the class.
        foreach ($this->migrator->getNotes() as $note) {
            $this->output->writeln($note);
        }
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', null, InputOption::VALUE_NONE, 'The name of the plugin.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
            ['step', null, InputOption::VALUE_OPTIONAL, 'The number of migrations to be reverted.'],
        ];
    }
}