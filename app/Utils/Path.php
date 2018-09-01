<?php
namespace Omega\Utils;

class Path{

	const WIN_DS = '\\';
	const LIN_DS = '/';

	private static $_DIRECTORY_SEPARATOR = DIRECTORY_SEPARATOR;

	public static function Combine()
	{
		$isLinux = false;
		if (self::$_DIRECTORY_SEPARATOR == self::LIN_DS) {
			$isLinux = true;
		}

		$path = '';
		foreach ( func_get_args() as $t )
		{	$t = rtrim(trim($t, self::WIN_DS),  self::WIN_DS);
			$t = rtrim(trim($t,  self::LIN_DS),  self::LIN_DS);

            if($isLinux)
            {
                $t = str_replace(self::WIN_DS, self::LIN_DS, $t);
            }

			$path .= $t . self::$_DIRECTORY_SEPARATOR;
		}
		$path = rtrim($path, self::$_DIRECTORY_SEPARATOR);
		if($isLinux)
		{
			$path = self::$_DIRECTORY_SEPARATOR . $path;
		}
		return $path;
	}

	public static function SetDirectorySeparator($ds){
        self::$_DIRECTORY_SEPARATOR = $ds;
    }

	public static function getExt($filepath)
	{
		return strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
	}

	public static function getFullPath($path)
	{
		return realpath($path);
	}

	public static function getSize($filepath)
	{
	    if(file_exists($filepath))
		    return filesize($filepath);
	    else
	        return 0;
	}

	public static function toUrl($path)
	{
		$path = str_replace(self::WIN_DS, DIRECTORY_SEPARATOR, $path);
		$path = str_replace(self::LIN_DS, DIRECTORY_SEPARATOR, $path);
		$folder = explode(DIRECTORY_SEPARATOR, $path);
		$url = '';
		foreach ( $folder as $t ) {
			$t = rtrim(trim($t, self::WIN_DS), self::WIN_DS);
			$t = rtrim(trim($t, self::LIN_DS), self::LIN_DS);
			$url .= $t . '/';
		}
		return substr($url, 0, strlen($url) -1);
	}

	public static function Make($path){

		$dir = pathinfo($path , PATHINFO_DIRNAME);

		if( is_dir($dir) )
		{
			return true;
		}
		else
		{
			if( self::Make($dir) )
			{
				if( mkdir($dir) )
				{
					chmod($dir , 0777);
					return true;
				}
			}
		}
		return false;
	}

	public static function MkDir($pathname , $mode = 0777 , $recursive = false){
	    if(!file_exists($pathname))
	        return mkdir($pathname, $mode, $recursive);
	    else
	        return false;
    }

    public static function RRmdir($dir)
    {

        $dir_content = scandir($dir);
        if ($dir_content !== false) {
            foreach ($dir_content as $entry) {
                if (!in_array($entry, array('.', '..'))) {
                    $entry = $dir . '/' . $entry;
                    if (!is_dir($entry)) {
                        unlink($entry);
                    } else {
                        self::RRmdir($entry);
                    }
                }
            }
        }
        return rmdir($dir);
    }

    public static function GetFiles($pathToFolder)
    {
        if ($handle = opendir($pathToFolder)) {
            $files = array();
            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != "..") {

                    $files[] = $entry;
                }
            }

            closedir($handle);
            return $files;
        }
        return array();
    }
}
