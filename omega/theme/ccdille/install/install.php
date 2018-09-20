<?php
use Omega\Library\Entity\ModuleArea;

/*********************************************************************
 * 																						*
 * 	  clean_blog THEME INSTALLATION FILE FOR OmegaCMSv3
 * 																						*
/*********************************************************************/

// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "ccdille";

// The title of your theme ...
$title = "ccdille by Sylvain Roh";

// A little description ...
$description = "Theme for Thomas Sandoz Website";

// And your website ...
$website = "http://rohs.ch/";

$colors = array(
	'#0085A1', '#ffffff', '#dddddd'
);

//Custom action that must be executed after the installation
function post_install()
{
	ModuleArea::Create('footer', 'ccdille');
    ModuleArea::Create('sidebar', 'ccdille');
}