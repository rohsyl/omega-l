<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 13.09.2017
 * Time: 17:12
 */

namespace Omega\Library\Plugin\Type;

use Omega\Library\Plugin\ATypeEntry;
use Omega\Library\Entity\Media;
use function Omega\Library\array_orderby;

class MediaChooser extends ATypeEntry {

    private $param = null;
    private $defaults = array(
        'multiple' => false,
        'preview' => false,
        'type' => array(
            Media::T_FOLDER, Media::T_PICTURE, Media::T_DOCUMENT, Media::T_MUSIC, Media::T_VIDEO, Media::T_OTHER, Media::T_VIDEO_EXT
        )
    );

    private function getParamSpecial() {
        if(!isset($this->param)) {
            $up = $this->getParam();
            $this->param = array_merge($this->defaults, isset($up) ? $up : array());
        }
        return $this->param;
    }

    public  function getHtml() {
        $param = $this->getParamSpecial();
        $uid = $this->getUniqId();
        $v = $this->getValue();
        if(!$param['multiple']){
            $m['uid'] = $uid;
            $m['value'] = $v;
            $m['param'] = $param;
            return $this->view('HtmlSimple', $m);
        }
        else{
            $values = isset($v) ? json_decode($v, true) : array();
            $m['uid'] = $uid;
            $m['values'] = $values;
            $m['param'] = $param;
            return $this->view('Html', $m);
        }
    }
    public  function getPostedValue() {
        $param = $this->getParamSpecial();
        $uid = $this->getUniqId();
        if(!$param['multiple']){
            return $this->getPost($uid.'-media-id');
        }
        else{

            $medias = array();
            foreach ($this->getPost($uid.'-media-id') as $i => $type) {
                $item = array(
                    'id' => $this->getPost($uid.'-media-id')[$i],
                    'order' => $this->getPost($uid.'-media-order')[$i]
                );
                if($this->getPost($uid.'-media-delete')[$i] == false && isset($item)) {
                    $medias[] = $item;
                }
            }

            $medias = array_orderby($medias, 'order', SORT_ASC);

            return json_encode($medias);
        }
    }

    public  function getObjectValue() {
        $param = $this->getParamSpecial();
        $v = $this->getValue();
        if(isset($v)) {
            if (!$param['multiple']) {
                return new Media($v);
            } else {
                $values = isset($v) ? json_decode($v, true) : array();
                return $values;
            }
        }
        return null;
    }

    public function getDoc(){
        return $this->view('Doc');
    }
}