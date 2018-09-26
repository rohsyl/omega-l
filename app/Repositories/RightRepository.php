<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 26.09.18
 * Time: 10:45
 */

namespace Omega\Repositories;


use Omega\Right;

class RightRepository
{
    private $right;

    public function __construct(Right $right) {
        $this->right = $right;
    }

    public function all(){
        return $this->right->get();
    }
}