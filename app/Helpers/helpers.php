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