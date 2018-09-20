<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07.08.2017
 * Time: 21:36
 */

namespace Omega\Library\Plugin\Type;


use Omega\Library\Plugin\ATypeEntry;
use Omega\Library\Util\Util;

class DropDown extends ATypeEntry {

    public function getHtml()
    {
        $param = $this->getParam();
        $uid = $this->getUniqId();
        $v = $this->getValue();
        if(isset($param['model'])){
            $className = $param['model'];
            if(!class_exists($className)){
                return 'DropDown data model "' . $param['model'] . '" not found';
            }
            $model = new $className($this);

            $modelData = $model->getKeyValueArray();

            $selectedValue = isset($v) ? $v : null;
            $html = '<select name="'.$uid.'" class="form-control">';
            foreach($modelData as $value => $title) {
                $checked = $selectedValue == $value ? 'selected' : '';
                $html .= '<option '.$checked.' value="'.$value.'">
                              '.$title.'
                          </option>';
            }
            $html .= '</select>';
        }else{
            $selectedValue = isset($v) ? $v : $param['default'];
            $options = $param['options'];
            $html = '<select name="'.$uid.'" class="form-control">';
            foreach($options as $value => $title) {
                $checked = $selectedValue == $value ? 'selected' : '';
                $html .= '<option '.$checked.' value="'.$value.'">
                              '.$title.'
                          </option>';
            }
            $html .= '</select>';
        }
        return $html;
    }

    public function getPostedValue()
    {
        return $this->getPost($this->getUniqId());
    }

    public  function getObjectValue() {
        $param = $this->getParam();
        $v = $this->getValue();
        $selectedValue = isset($v) ? $v : $param['default'];
        $ret = array(
            'title' => isset($param['options'][$selectedValue]) ? $param['options'][$selectedValue] : '',
            'value' => $selectedValue
        );
        return $ret;
    }

    public function getDoc(){
        return $this->view('Doc');
    }
}

/*

Exemple hard coded values
{
	"default": 3,
	"options": {
		"3": "25%",
		"4": "33%",
		"5": "42%",
		"6": "50%",
		"8": "66%",
		"9": "75%"
	}
}
 */


/*
Exemple database content value
{
	"model" : "Omega\\Plugin\\DividedContent\\Model\\DropDownPage"
}
 */