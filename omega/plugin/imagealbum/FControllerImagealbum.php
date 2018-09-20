<?php
namespace Omega\Plugin\Imagealbum;

use Omega\Library\Plugin\FController;
use Omega\Plugin\Imagealbum\Model\Albums;
use Omega\Library\Entity\Entity;
use Omega\Library\Util\Url;

class FControllerImagealbum extends  FController {

		public function __construct(){
			parent::__construct('imagealbum');
            $this->includeFile( 'constant.php');
		}
		
		public function registerDependencies()
		{
			return array(
				'css' => array(
                    'plugin/imagealbum/css/blueimp-gallery.min.css'
				),
				'js' => array(
                    'plugin/imagealbum/js/blueimp-gallery.min.js'
				)
			);
		}
		
		public function display($args, $data)
		{
            if(isset($_GET['id'])){
                $idSection = $_GET['id'];
                Entity::Page()->setVisibleTitle(false);
                $m['section'] = Albums::getSection($idSection);
                $m['albums'] = Albums::getAllAlbums($idSection);
                $m['cfg'] = Albums::getConfig();

                foreach($m['albums'] as &$album){
                    $album['images'] = Albums::getAllImage($album[ALB_ID]);
                }
                return $this->partialView('display-albums', $m);
            }
            else{
                $m['sections'] = Albums::getAllSections();
                $m['cfg'] = Albums::getConfig();
                return $this->partialView('display-sections', $m);
            }
		}
	}