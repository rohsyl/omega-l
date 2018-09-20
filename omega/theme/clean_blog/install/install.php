<?php
use Omega\Library\Entity\ModuleArea;

/*********************************************************************
 * 																						*
 * 	  clean_blog THEME INSTALLATION FILE FOR OmegaCMSv3
 * 																						*
/*********************************************************************/

// The name of your theme (this value must be the same as the name of the theme's directory) ..
$name = "clean_blog";

// The title of your theme ...
$title = "Clean Blog by templated";

// A little description ...
$description = "Clean blog is a carefully styled Bootstrap blog theme that is perfect for personal or company blogs. This theme features four HTML pages including a blog index, an about page, a sample post, and a contact page. Adapted by Sylvain Roh to make it work with OmegaCMS";

// And your website ...
$website = "https://startbootstrap.com/template-overviews/clean-blog/";

$colors = array(
	'#0085A1', '#ffffff', '#dddddd'
);

//Custom action that must be executed after the installation
function post_install()
{
	ModuleArea::Create('footer', 'clean_blog');
}