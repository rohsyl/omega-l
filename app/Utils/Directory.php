<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 01.12.18
 * Time: 23:31
 */

namespace Omega\Utils;

class Directory
{
    public static function isWritable($directory){
        if(file_exists($directory)){
            return is_writable($directory);
        }
        return false;
    }
}