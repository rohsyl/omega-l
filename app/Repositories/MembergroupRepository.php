<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 09.10.18
 * Time: 17:24
 */

namespace Omega\Repositories;


use Omega\Membergroup;

class MembergroupRepository
{
    private $membergroup;

    public function __construct(Membergroup $membergroup){
        $this->membergroup = $membergroup;
    }

    public function all(){
        return $this->membergroup->get();
    }
}