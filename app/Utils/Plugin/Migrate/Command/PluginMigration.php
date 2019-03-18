<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.03.19
 * Time: 12:15
 */

namespace Omega\Utils\Plugin\Migrate\Command;


trait PluginMigration
{

    private function getPluginName(){
        return trim($this->input->getArgument('name'));
    }

    protected function getMigrationPath()
    {
        $name = $this->getPluginName();
        $path = plugin_migrations_path($name);

        if(!file_exists($path))
            mkdir($path, 0777, true);

        return $path;
    }
}