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

class RadioButtons extends ATypeEntry {

    public function getHtml()
    {
        $param = $this->getParam();
        $uid = $this->getUniqId();
        $v = $this->getValue();
        $selectedValue = isset($v) ? $v : $param['default'];
        $options = $param['options'];

        $i = 0;
        $html = '<div class="form-group">';
        foreach($options as $value => $title) {
            $checked = $selectedValue == $value ? 'checked' : '';
            $html .= '<label for="'.$uid.'-'.$i.'" class="radio-inline">
                          <input name="'.$uid.'" id="'.$uid.'-'.$i.'" value="'.$value.'" '.$checked.' type="radio"> '.$title.'
                      </label>';
            $i++;
        }
        $html .= '</div>';
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
            'title' => $param['options'][$selectedValue],
            'value' => $selectedValue
        );
        return $ret;
    }

    public function getDoc(){
        return $this->view('Doc');
    }
}