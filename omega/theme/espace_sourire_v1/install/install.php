<?php 

/*********************************************************************
 * 																						*
 * 	  espace_sourire_v1 THEME INSTALLATION FILE FOR OmegaCMSv3
 * 																						*
/*********************************************************************/

// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "espace_sourire_v1";

// The title of your theme ...
$title = "Main Theme";

// A little description ...
$description = "espace_sourire_v1";

// And your website ...
$website = "http://espacesourire.ch";

// bleu (highlight) | blanc (fond) | gris (ecriture)
$colors = array(
	'#222222', '#2e0742', '#dddddd'
);

//Custom action that must be executed after the installation
function post_install()
{
	ModuleArea::Create('footer', 'espace_sourire_v1');
}