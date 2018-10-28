<?php
namespace Omega\Utils\Plugin\Type;

use Omega\Utils\Plugin\ATypeEntry;

class IconChooser extends ATypeEntry {

    public  function getPostedValue() {
        $uid = $this->getUniqId();
        return $this->getPost($uid);
    }

    public  function getObjectValue() {
        $v = $this->getValue();
        $v = isset($v) ? $v : '';
        return $v;
    }

    public  function getHtml() {
        $v = $this->getObjectValue();
        $m['uid'] = $this->getUniqId();
        $m['value'] = $v;
        return $this->view('Html', $m);
    }

    public function getDoc(){
        return $this->view('Doc');
    }
}