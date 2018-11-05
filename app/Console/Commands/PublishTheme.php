<?php

namespace Omega\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublishTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omega:theme:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the `assets` directory of the current theme to the `public` directory';

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
        $code = Artisan::call('vendor:publish', [
            '--tag' => 'theme',
            '--force' => true
        ]);

        $this->info(Artisan::output());

        return $code;
    }
}
