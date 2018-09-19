<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 05.08.2017
 * Time: 19:06
 */
namespace Omega\Utils\Plugin;

class FormEntryValue{

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getId(){
        return $this->value['id'];
    }

    public function getValue(){
        return $this->value['value'];
    }
}