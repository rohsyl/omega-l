<?php
namespace Omega\Plugin\Document;

use Omega\Library\Plugin\FController;

class FControllerDocument extends FController {

    public function __construct(){
        parent::__construct('document');
        $this->includeFile('library.php');

    }

    public function registerDependencies() {
        return array(
            'css' => array(
                'plugin/document/css/style.css',
                'assets/bootstrap_composant/css/bootstrap-grid.min.css'
            ),
            'js' => array(
            )
        );
    }

    public function display($args, $data) {
        $placement = isset($args['placement']) ? $args['placement'] : 'content';
        if($placement == 'modulearea') {
            return $this->partialView('display-modulearea', $data);
        }
        else {
            return $this->partialView('display-content', $data);
        }
    }
}