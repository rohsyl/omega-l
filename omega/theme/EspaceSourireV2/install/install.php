<?php
use Omega\Library\Entity\ModuleArea;

/*********************************************************************
 *
 *       EspaceSourireV2 THEME INSTALLATION FILE FOR OmegaCMSv3
 *
/*********************************************************************/
// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "EspaceSourireV2";
// The title of your theme ...
$title = "Espace Sourire v2 theme by R-Men based on Snapshot by Untitled Design";
// A little description ...
$description = "Theme for EspaceSourire.ch v2";
// And your website ...
$website = "https://templated.co/snapshot";
$colors = array(
    '#222222', '#2e0742', '#dddddd'
);
//Custom action that must be executed after the installation
function post_install() {
    // Ici nous avons la création d'un module area.
    ModuleArea::Create('formContact', 'EspaceSourireV2');
    ModuleArea::Create('footerLeft', 'EspaceSourireV2');
    ModuleArea::Create('footerCenter', 'EspaceSourireV2');
    ModuleArea::Create('footerRight', 'EspaceSourireV2');
	ModuleArea::Create('logoFull', 'EspaceSourireV2');
}