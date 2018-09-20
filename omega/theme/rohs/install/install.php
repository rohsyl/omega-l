<?php
use Omega\Library\Entity\ModuleArea;

/*********************************************************************
 *
 *       rohs THEME INSTALLATION FILE FOR OmegaCMSv3
 *
/*********************************************************************/
// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "rohs";
// The title of your theme ...
$title = "Industrious by templated";
// A little description ...
$description = "A modern business-oriented design with a video banner.";
// And your website ...
$website = "https://templated.co/industrious";
$colors = array(
    '#ce1b28', '#111111', '#ffffff'
);
//Custom action that must be executed after the installation
function post_install() {
    // Ici nous avons la création d'un module area.
    ModuleArea::Create('footer_left', 'rohs');
    ModuleArea::Create('footer_center', 'rohs');
    ModuleArea::Create('footer_right', 'rohs');
}
