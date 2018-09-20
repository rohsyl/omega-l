<?php
use Omega\Library\Entity\ModuleArea;

/*********************************************************************
 *
 *       mongolo THEME INSTALLATION FILE FOR OmegaCMSv3
 *
/*********************************************************************/
// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "mongolo";
// The title of your theme ...
$title = "Mongolo theme based by R-Men on indigo by Ulziibat";
// A little description ...
$description = "Mongoloooooooo.";
// And your website ...
$website = "https://www.free-css.com/free-css-templates/page229/indigo";
$colors = array(
    '#000000', '#ffffff'
);
//Custom action that must be executed after the installation
function post_install() {
    // Ici nous avons la création d'un module area.
    ModuleArea::Create('footerLeft', 'mongolo');
    ModuleArea::Create('footerCenter', 'mongolo');
    ModuleArea::Create('footerRight', 'mongolo');
}