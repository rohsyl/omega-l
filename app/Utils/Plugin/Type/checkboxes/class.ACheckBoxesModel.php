<?php
namespace Omega\Library\Plugin\Type\CheckBoxes;

abstract class ACheckBoxesModel{

    private $entry;

    public function __construct($entry) {
        $this->entry = $entry;
    }

    protected function getEntry(){
        return $this->entry;
    }

    public abstract function getKeyValueArray();
}