<?php
/**
 * OmegaCMS
 * Some helpers functions usefull for Omega.
 */

define('SALT', '*#yolo#$%^&*fr0mage');

// Authorized extensions for upload
// Pictures
define('AUTHORIZED_PICTURE_TYPE', serialize(array(
    'jpg',        'jpeg',
    'png',        'svg',
    'gif'
)));
// Videos
define('AUTHORIZED_VIDEO_TYPE', serialize(array(
    'mp4',     'm4v',
    'mov',     'wmv',
    'avi',     'mpg'
)));
// Audios
define('AUTHORIZED_AUDIO_TYPE', serialize(array(
    'mp3',     'm4a',
    'ogg',     'wav'
)));
// Documents
define('AUTHORIZED_DOCUMENT_TYPE', serialize(array(
    'pdf',
    'doc',     'docx',
    'ppt',     'pptx',
    'pps',     'ppsx',
    'xls',     'xlsx',
    'odt',     'odp',
    'ods',    'ott'
)));
define('AUTHORIZED_OTHER_TYPE', serialize(array(

)));

$ext = array_merge(
    unserialize(AUTHORIZED_PICTURE_TYPE),
    unserialize(AUTHORIZED_VIDEO_TYPE),
    unserialize(AUTHORIZED_AUDIO_TYPE),
    unserialize(AUTHORIZED_DOCUMENT_TYPE),
    unserialize(AUTHORIZED_OTHER_TYPE)
);
$afti = '';
foreach ($ext as $e){
    $afti .= $e.'|';
}

define('AUTHORIZED_FILE_TYPE_INLINE', trim($afti, '|'));


use Illuminate\Support\Facades\Route;
use Collective\Html\FormFacade;
use Omega\Config;

if (!function_exists('add_action')) {
    /**
     * Omega : return a menu entry
     * @param $url string The url
     * @param $icon string The icon
     * @param $text string The label
     * @param boolean|null $condition Display only if this condition is true
     * @return string The view
     */
    function add_action($url, $icon, $text, $condition = null) {
        if(is_null($condition) || ($condition)){
            return view('helpers.menuentry')->with([
                'url' => $url,
                'icon' => $icon,
                'text' => $text
            ]);
        }
    }
}

if (!function_exists('om_config')) {
    /**
     * Get or set the key value in the configs table in the datable
     * @param $arg string|array if a string is passed, it will return the value of the config entry.
     *                          if an array is passed, it will set the key entry value.
     * @return string The value
     */
    function om_config($arg){
        if(is_array($arg)){
            $key = key($arg);
            $config = Config::firstOrNew(['key' => $key]);
            $config->value = $arg[$key];
            $config->save();
            return $config->value;
        }
        else{
            $config = Config::where('key', $arg)->first();
            return isset($config) ? $config->value : null;
        }
    }
}


if (!function_exists('class_active_route')) {
    /**
     * Check if the given $routeName is the current route, if yes return 'class="active"' else return nothing
     * @param $routeName string The name of the route
     * @return string 'class="active"' or nothing
     */
    function class_active_route($routeName)
    {
        return Route::currentRouteName() == $routeName ? ' class="active"' : '';
    }
}

if (!function_exists('media_path')) {
    /**
     * Get the full path to the public/media directory
     * @return string The full path
     */
    function media_path(){
        return public_path('media');
    }
}





if (!function_exists('humanReadableBytes')) {
    /**
     * Convert bytes to human readable string
     * @param $size int The size in bytes
     * @param string $unit automatic or GB, MB, KB
     * @return string The human readable string
     */
    function humanReadableBytes($size,$unit="") {
        if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)." GB";
        if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)." MB";
        if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)." KB";
        return number_format($size)." bytes";
    }
}

if (!function_exists('getMaximumFileUploadSize')) {
    /**
     * Get the maxmimum allowed upload size
     * @return int In bytes, The size
     */
    function getMaximumFileUploadSize()
    {
        return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));
    }
}

if (!function_exists('convertPHPSizeToBytes')) {
    /**
     * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
     * @param $sSize The string size
     * @return bool|int|string The size in bytes
     */
    function convertPHPSizeToBytes($sSize)
    {
        if ( is_numeric( $sSize) ) {
            return $sSize;
        }
        $sSuffix = substr($sSize, -1);
        $iValue = substr($sSize, 0, -1);
        switch(strtoupper($sSuffix)){
            case 'P':
                $iValue *= 1024;
            case 'T':
                $iValue *= 1024;
            case 'G':
                $iValue *= 1024;
            case 'M':
                $iValue *= 1024;
            case 'K':
                $iValue *= 1024;
                break;
        }
        return $iValue;
    }
}

if(!function_exists('to_select')) {
    /**
     * Convert a collection of object to a key/value array
     * @param $collection array The collection
     * @param string $keyValue The name of the property value
     * @param string $keyKey The name of the property key
     * @return array The key value array
     */
    function to_select($collection, $keyValue = 'title', $keyKey = 'id', $append = []){
        $l = [];
        foreach($collection as $item){
            $l[strval($item->{$keyKey})] = $item->{$keyValue};
        }
        return $append + $l;
    }
}


if(!function_exists('unique_slug')) {
    /**
     * Generate a slug and ensure it is unique in the database
     * @param $model object
     * @param $input string
     * @param string $key The key
     * @return string The slug
     */
    function unique_slug($model, $input, $key = 'slug' ){
        $i = null;
        $slug = str_slug($input);
        while($model->where($key, $slug.$i)->exists()){
            if(!isset($i))
                $i = 1;
            else
                $i++;
        }
        return $slug.$i;
    }
}


if(!function_exists('clean_text')) {
    /**
     * Create a user friendly text from a slug
     * @param $text
     * @return mixed|null|string|string[]
     */
    function clean_text($text){
        $text = preg_replace('/\.[^.]+$/','',$text);	//Remove extention
        $text = str_replace("_", " ", $text);
        $text = ucfirst($text);
        return $text;
    }
}