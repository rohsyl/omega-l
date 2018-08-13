<?php


function add_action($url, $icon, $text, $condition = null) {
    if(is_null($condition) || ($condition)){
        return view('helpers.menuentry')->with([
            'url' => $url,
            'icon' => $icon,
            'text' => $text
        ]);
    }
}

/**
 * Get or set the key value in the configs table in the datable
 * @param $arg string|array if a string is passed, it will return the value of the config entry.
 *                          if an array is passed, it will set the key entry value.
 * @return string The value
 */
function om_config($arg){
    if(is_array($arg)){
        $config = \Omega\Config::firstOrNew(['key' => key($arg)]);
        $config->value = $arg[key($arg)];
        $config->save();
        return $config->value;
    }
    else{
        return \Omega\Config::where('key', $arg)->first()->value;
    }
}

