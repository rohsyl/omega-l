<?php
use Omega\Library\Entity\ModuleArea;

/*********************************************************************
 * 																						*
 * 	  nocturne THEME INSTALLATION FILE FOR OmegaCMSv3.1
 * 																						*
/*********************************************************************/

// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "nocturne";

// The title of your theme ...
$title = "Nocturne TDS by Sylvain Roh";

// A little description ...
$description = "";

// And your website ...
$website = "http://rohs.ch/";

$colors = array(
	'#020B13', '#ffffff', 'red'
);

//Custom action that must be executed after the installation
function post_install()
{
	ModuleArea::Create('footer_left', 'nocturne');
	ModuleArea::Create('footer_center', 'nocturne');
	ModuleArea::Create('footer_right', 'nocturne');
	ModuleArea::Create('copyright', 'nocturne');
}