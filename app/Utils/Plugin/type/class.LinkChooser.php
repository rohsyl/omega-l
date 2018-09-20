<?php
namespace Omega\Library\Plugin\Type;

use Omega\Library\Plugin\ATypeEntry;
use Omega\Library\Util\LinkChooser as LC;

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