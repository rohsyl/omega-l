<?php
namespace Omega\Plugin\Image;

use Omega\Library\Plugin\FController;

	class FControllerImage extends  FController {


		public function __construct() {
			parent::__construct('image');
		}
		
		public function registerDependencies()
		{
			return array(
				'css' => array(
					'plugin/image/css/style.css'
				),
				'js' => array(
                    'plugin/image/js/parallax.min.js'
				)
			);
		}

		public function display( $args, $data) {
            $placement = isset($args['placement']) ? $args['placement'] : 'content';
			return $this->view( $data );
		}
	}