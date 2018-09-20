<?php
namespace Omega\Plugin\Fichedepresentation;

use Omega\Library\Plugin\FController;
use Omega\Library\Entity\Entity;
use Omega\Library\Util\Url;
use Omega\Plugin\Fichedepresentation\Model\LocalArticles;

class FControllerFichedepresentation extends  FController {

		public function __construct(){
			parent::__construct('fichedepresentation');
            $this->includeFile( 'constant.php');
		}
		
		public function registerDependencies()
		{
			return array(
				'css' => array(
                    'plugin/fichedepresentation/css/style.css'
				),
				'js' => array(
				)
			);
		}
		
		public function display($args, $data)
		{
            $articles = LocalArticles::getAll();
            $m['articles'] = $articles;
            return $this->view($m);
		}
	}