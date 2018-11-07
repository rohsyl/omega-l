<?php
namespace OmegaPlugin\Gallery;


use Omega\Utils\Plugin\FController;

define('GALLERY_DISPLAY_WALL', 1);
define('GALLERY_DISPLAY_SLIDER', 2);

class FControllerGallery extends  FController {

    public function __construct(){
        parent::__construct('gallery');
        //$this->includeFile('library.php');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                $this->asset('css/style.css'),
                $this->asset('css/blueimp-gallery.min.css'),
                $this->asset('css/owl.carousel.min.css'),
                $this->asset('css/owl.theme.default.min.css')
            ),
            'js' => array(
                $this->asset('js/blueimp-gallery.min.js'),
                $this->asset('js/owl.carousel.min.js')
            )
        );
    }

    public function display($args, $data)
    {
        $display = isset($data['display']['value']) ? $data['display']['value'] : GALLERY_DISPLAY_WALL;
        $t = $this;

        // expose this method to the view
        $data['unique'] = function($key) use ($t){
            return $t->unique($key);
        };

        if($display == GALLERY_DISPLAY_WALL) {
            return $this->view('display')->with($data);
        }
        else {
            return $this->view('display_slider')->with($data);
        }
    }
}