<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 17.08.2017
 * Time: 18:12
 */

namespace Omega\Library\Plugin\Type;

use Omega\Library\Plugin\ATypeEntry;
use Omega\Library\Util\Util;

class CheckBoxes extends ATypeEntry {

    public  function getHtml()
    {
        $uid = $this->getUniqId();
        $param = $this->getParam();
        $values = $this->getObjectValue();
        if(isset($param['model'])){
            $className = $param['model'];
            if(!class_exists($className)){
                return 'DropDown data model "' . $param['model'] . '" not found';
            }
            $model = new $className($this);

            $modelData = $model->getKeyValueArray();

            $html = '';
            foreach($modelData as $key => $title) {
                $checked = isset($values[$key]) && $values[$key] ? 'checked' : '';
                $html .= '<div class="checkbox">
                            <label>
                                <input type="checkbox" '.$checked.' name="'.$uid.'[]" value="'.$key.'"> 
                                '.$title.'
                            </label>
                          </div>';
            }
            return $html;
        }
        else{
            $options = $param['options'];
            $html = '';
            foreach($options as $key => $title) {
                $checked = $values[$key] ? 'checked' : '';
                $html .= '<div class="checkbox">
              <label>
                <input name="'.$uid.$key.'" type="checkbox" '.$checked.' value="'.$key.'">
                '.$title.'
              </label>
            </div>';
            }
            return $html;
        }
    }

    public  function getPostedValue()
    {
        $param = $this->getParam();

        $values = array();
        if(isset($param['model'])){
            foreach($this->getPost($this->getUniqId()) as $item){
                $values[$item] = true;
            }
        }
        else{

            foreach($param['options'] as $key => $title) {
                $values[$key] = $this->existsPost($this->getUniqId().$key);

            }
        }
        return json_encode($values);
    }

    public  function getObjectValue()
    {
        $param = $this->getParam();
        $v = $this->getValue();
        if(isset($param['model'])){

            $par = json_decode($v, true);
            return $par;
            //Util::printR($par);
            //return isset($v) ? array_keys($par) : array();
        }
        else{
            $defaults = $param['default'];
            return isset($v) ? json_decode($v, true) : $defaults;
        }
    }

    public function getDoc(){
        return $this->view('Doc');
    }
}


/*
Exemple hard coded values
{
	"default": {
		"opt1": true,
		"opt2": false
	},
	"options": {
		"opt1": "Option 1",
		"opt2": "Option 2"
	}
}

/*
Exemple database content value
{
	"model" : "Omega\\Plugin\\News\\Model\\CheckBoxesCategoriesModel"
}
 */