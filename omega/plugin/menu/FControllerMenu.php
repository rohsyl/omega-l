<?php
namespace Omega\Plugin\Menu;

use Omega\Library\Plugin\FController;

class FControllerMenu extends FController {

    public function __construct() {
        parent::__construct('menu');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                //'plugin/menu/css/mtree.css',
                //'plugin/menu/css/horizontal.css'
            ),
            'js' => array(
                'plugin/menu/js/jquery.velocity.min.js',
                'plugin/menu/js/mtree.js'
            )
        );
    }

    public function display( $userParam, $data ) {
        $defaultParam = array(
            'idMenu' => 0,
            'beforeTitle' => '<h4>',
            'afterTitle' => '</h4>',
            'displayTitle' => true,
            'beforeContent' => '',
            'afterContent' => '',
            'isVertical' => true,
            'divClass' => 'module-'.$this->name.'-'.$userParam['idMenu'],
            'ulClass' => '',
            'liClass' => ''
        );

        $param = array_merge($defaultParam, $userParam);
        $m['param'] = $param;

        echo $this->view( $m );
    }
}