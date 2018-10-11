<?php
use Omega\Library\Entity\ModuleArea;
use Omega\Utils\Theme\Installer;

/**
 * @return Installer
 */
return Installer::For('clean_blog')
    ->set([
        'title' => 'Clean Blog by templated',
        'description' => 'Clean blog is a carefully styled Bootstrap blog theme that is perfect for personal or company blogs. This theme features four HTML pages including a blog index, an about page, a sample post, and a contact page. Adapted by Sylvain Roh to make it work with OmegaCMS',
        'website' => 'https://startbootstrap.com/template-overviews/clean-blog/',
        'colors' => ['#0085A1', '#ffffff', '#dddddd']
    ])
    ->postInstall(function($name){
        ModuleArea::Create('footer', $name);
    });
