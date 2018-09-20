<?php
namespace Omega\Plugin\DividedContent;

use function Omega\Library\backoffice_grant_access;
use Omega\Library\Plugin\FController;
use Omega\Library\Util\Util;


define('TYPE_COL_2', 1);
define('TYPE_COL_3', 2);
define('TYPE_COL_4', 3);
define('TYPE_TABS', 4);
define('TYPE_COLLAPSE', 5);

class FControllerDividedcontent extends  FController {


    public function __construct() {
        parent::__construct('dividedcontent');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'assets/bootstrap_composant/css/bootstrap-tabs.min.css',
                'assets/bootstrap_composant/css/bootstrap-collapse.min.css'
            ),
            'js' => array(
                'assets/bootstrap_composant/js/bootstrap-tabs.min.js',
                'assets/bootstrap_composant/js/bootstrap-collapse.min.js'
            )
        );
    }

    public function display( $args, $data ) {
        $data['id'] = $args['settings']['compId'];
        switch($data['type']['value']){
            case TYPE_COL_2:
                $data['countCol'] = 2;
                return $this->partialView('display-column', $data);
                break;
            case TYPE_COL_3:
                $data['countCol'] = 3;
                return $this->partialView('display-column', $data);
                break;
            case TYPE_COL_4:
                $data['countCol'] = 4;
                return $this->partialView('display-column', $data);
                break;
            case TYPE_TABS:
                return $this->partialView('display-tabs', $data);
                break;
            case TYPE_COLLAPSE:
                return $this->partialView('display-collapse', $data);
                break;
        }
        return null;
    }
}