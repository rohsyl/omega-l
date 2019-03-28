<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 28.03.19
 * Time: 13:16
 */

namespace Omega\Repositories;


use Omega\Utils\Path;

class DataTypeRepository
{
    public function all(){
        $namespace = "Omega\\Utils\\Plugin\\Type\\";
        $path = Path::Combine(app_path(), 'Utils', 'Plugin', 'Type');
        $files = Path::GetFiles($path);
        $classes = array();
        foreach ($files as $file){
            if(is_file(Path::Combine($path, $file))){
                $className = $namespace . explode('.', $file)[0];
                if(class_exists($className)){
                    $classes[] = $className;
                }
            }
        }
        return $classes;
    }
}