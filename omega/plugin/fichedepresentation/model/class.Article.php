<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 20.10.2017
 * Time: 10:34
 */
namespace Omega\Plugin\Fichedepresentation\Model;

class Article{

    private $ref;
    private $design;

    public function __construct($ref, $design)
    {
        $this->ref = $ref;
        $this->design = ucfirst(strtolower($design));
    }

    public function getRef(){
        return $this->ref;
    }

    public function getDesignation(){
        return $this->design;
    }
}