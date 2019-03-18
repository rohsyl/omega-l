<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 15.03.19
 * Time: 15:44
 */

namespace Omega\Utils\Plugin\Migrate;


use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Migrator extends \Illuminate\Database\Migrations\Migrator
{
    public function __construct()
    {
        parent::__construct(
            new MigrationRepository(resolve('db')),
            resolve('db'),
            resolve("files")
        );
    }

    public function setPluginName($name){
        $this->repository->setPluginName($name);
    }

    public function resolve($file)
    {
        $class = Str::studly(implode('_', array_slice(explode('_', $file), 4)));

        return new $class;
    }
}