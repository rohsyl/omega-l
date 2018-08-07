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