<?php
namespace Omega\Utils\Plugin\Type;

use Omega\Utils\Plugin\ATypeEntry;
use Omega\Utils\LinkChooser as LC;

class LinkChooser extends ATypeEntry {

    public  function getPostedValue() {
        $uid = $this->getUniqId();
        return LC::Decode($this->getPost($uid));
    }

    public  function getObjectValue() {
        $v = $this->getValue();
        return LC::GetLink($v);
    }

    public  function getHtml() {
        $v = $this->getValue();
        $v = isset($v) ? $v : '';
        $m['uid'] = $this->getUniqId();
        $m['value'] = LC::Encode($v);
        return $this->view('Html', $m);
    }

    public function getDoc(){
        return $this->view('Doc');
    }
}