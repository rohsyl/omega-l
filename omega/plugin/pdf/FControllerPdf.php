<?php
namespace Omega\Plugin\Pdf;

use Omega\Library\Plugin\FController;

	class FControllerPdf extends  FController {


		public function __construct() {
			parent::__construct('pdf');
		}
		
		public function registerDependencies()
		{
			return array(
				'css' => array(
				),
				'js' => array(
				)
			);
		}

		public function display( $args, $data ) {
			return $this->view( $data );
		}
	}