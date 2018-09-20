<?php 

/*********************************************************************
 *
 * 	  							INSTALLATION FILE FOR Iridium
 *
/*********************************************************************/

// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "nilson";

// The title of your theme ...
$title = "Nilson";

// A little description ...
$description = "Theme by Roh Sylvain";

// Your website ...
$website = "http://sylvainroh.xyz/";

$colors = array(
	'#ffffff', '#000000', '#cccccc'
);

//Custom action that must be executed after the installation
function post_install()
{
	ModuleArea::Create('footer',  'nilson');
}