<?php
use Omega\Library\Entity\ModuleArea;

/*********************************************************************
 *
 *       hielo THEME INSTALLATION FILE FOR OmegaCMSv3
 *
/*********************************************************************/
// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "templated-hielo";
// The title of your theme ...
$title = "Hielo - A FREE RESPONSIVE WEB SITE TEMPLATE BY TEMPLATED";
// A little description ...
$description = "A super slick landing page with a parallax (!!!) banner carousel.";
// And your website ...
$website = "https://templated.co/hielo";
$colors = array(
    '#000000', '#ffffff', '#a6a6a6'
);
//Custom action that must be executed after the installation
function post_install() {
    // Ici nous avons la création d'un module area.
    ModuleArea::Create('footer', 'templated-hielo');
}