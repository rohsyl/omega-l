<?php
namespace Omega\Plugin\LinkedSlider;

use Omega\Library\Plugin\BController;

class BControllerLinkedslider extends  BController {


    public function __construct() {
        parent::__construct('linkedSlider');
    }

    public function index() {
        return 'Nothing to do here.';
    }


    public function formComponent($args){
        $args['slides'] = isset($args['slides']) ? $args['slides'] : array();
        return $this->partialView('formComponent', $args);
    }

    public function updateComponent($args){
        $slideItems = array();
        foreach($_POST[$this->fieldName('type')] as $id => $value)
        {
            $item = array();
            $item['type'] = $_POST[$this->fieldName('type')][$id];
            if($item['type'] == 'image'){
                $item['slide'] = $_POST[$this->fieldName('slide')][$id];
                $item['link'] =  $_POST[$this->fieldName('link')][$id];
                //$item['title'] = $_POST[$this->fieldName('title')][$id];
                //$item['descr'] = $_POST[$this->fieldName('descr')][$id];
            }
            else{
                $item['url'] = $_POST[$this->fieldName('url')][$id];
                //$item['title'] = $_POST[$this->fieldName('title')][$id];
                //$item['descr'] = $_POST[$this->fieldName('descr')][$id];
            }
            $slideItems[] = $item;
        }
        $args['slides'] = $slideItems;
        return $args;
    }
}