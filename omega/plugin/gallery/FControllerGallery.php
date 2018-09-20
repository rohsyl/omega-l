<?php
namespace Omega\Plugin\Gallery;

use Omega\Library\Plugin\FController;
use Omega\Library\Util\Util;

define('GALLERY_DISPLAY_WALL', 1);
define('GALLERY_DISPLAY_SLIDER', 2);

class FControllerGallery extends  FController {

    public function __construct(){
        parent::__construct('gallery');
        $this->includeFile('library.php');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'plugin/gallery/css/style.css',
                'plugin/gallery/css/blueimp-gallery.min.css',
                'plugin/gallery/css/owl.carousel.min.css',
                'plugin/gallery/css/owl.theme.default.min.css'
            ),
            'js' => array(
                'plugin/gallery/js/blueimp-gallery.min.js',
                'plugin/gallery/js/owl.carousel.min.js'
            )
        );
    }

    public function display($args, $data)
    {
        $display = isset($data['display']['value']) ? $data['display']['value'] : GALLERY_DISPLAY_WALL;

        if($display == GALLERY_DISPLAY_WALL) {
            return $this->partialView('display', $data);
        }
        else {
            return $this->partialView('display-slider', $data);
        }
    }
}