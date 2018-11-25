<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 23.11.18
 * Time: 14:37
 */

namespace Omega\Utils\Plugin\Type;

use Omega\Utils\Plugin\ATypeEntry;

class HtmlEditor extends ATypeEntry
{

    public function getPostedValue() {
        return $this->getPost($this->getUniqId());
    }

    public function getDoc() {
        return $this->view('Doc');
    }

    public function getObjectValue() {
        return $this->getValue();
    }

    public function getHtml() {
        return $this->view('Html', [
            'uid' => $this->getUniqId(),
            'value' => $this->getObjectValue()
        ]);
    }
}