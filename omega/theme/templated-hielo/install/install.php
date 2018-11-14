<?php
use Omega\Facades\ModuleArea;
use Omega\Utils\Theme\Installer;

/**
 * @return Installer
 */
return Installer::For('templated-hielo')
    ->set([
        'title' => 'Hielo - A FREE RESPONSIVE WEB SITE TEMPLATE BY TEMPLATED',
        'description' => 'A super slick landing page with a parallax (!!!) banner carousel.',
        'website' => 'https://templated.co/hielo',
        'colors' => ['#000000', '#ffffff', '#a6a6a6']
    ])
    ->postInstall(function($name){
        ModuleArea::Create('footer', $name);
        ModuleArea::Create('sidebar', $name);
    });
