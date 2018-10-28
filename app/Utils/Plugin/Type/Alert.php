<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 26.10.2017
 * Time: 08:34
 */


namespace Omega\Utils\Plugin\Type;

use Omega\Utils\Plugin\ATypeEntry;

class Alert extends ATypeEntry {

    public  function getHtml()
    {
        $uid = $this->getUniqId();
        $param = $this->getParam();
        $html = '<div class="alert alert-'.$param['type'].' alert-'.$uid.'">'.$param['text'].'</div>';
        return $html;
    }

    public  function getPostedValue()
    {
        return '';
    }

    public  function getObjectValue()
    {
        return $this->getParam();
    }

    public function getDoc(){
        return $this->view('Doc');
    }
}