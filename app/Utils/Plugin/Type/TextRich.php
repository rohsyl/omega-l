<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 05.08.2017
 * Time: 19:12
 */

namespace Omega\Utils\Plugin\Type;

use Omega\Utils\Plugin\ATypeEntry;
use Omega\Utils\Entity\Page;

class TextRich extends ATypeEntry {

    public function getHtml()
    {
        $uid = $this->getUniqId();
        $value = $this->getObjectValue();
        $html = '<textarea class="form-control '.$uid.'" name="'.$uid.'">'.$value.'</textarea>
            <script>
                omega.initSummerNote(\'.'.$uid.'\');
            </script>';
        return $html;
    }

    public function getPostedValue()
    {
        return $this->getPost($this->getUniqId());
    }

    public  function getObjectValue()
    {
        $v = $this->getValue();
        return isset($v) ? Page::RenderSpecialContent($v) : '';
    }

    public function getDoc(){
        return $this->view('Doc');
    }
}