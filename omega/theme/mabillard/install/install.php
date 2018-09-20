<?php
use Omega\Library\Entity\ModuleArea;

/*********************************************************************
 * 																						*
 * 	  mabillard THEME INSTALLATION FILE FOR OmegaCMSv3
 * 																						*
/*********************************************************************/

// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "mabillard";

// The title of your theme ...
$title = "Mabillard";

// A little description ...
$description = "";

// And your website ...
$website = "";

$colors = array(
	'#A8D3AF', '#ffffff', '#000000'
);

//Custom action that must be executed after the installation
function post_install()
{
	ModuleArea::Create('footer', 'mabillard');
}