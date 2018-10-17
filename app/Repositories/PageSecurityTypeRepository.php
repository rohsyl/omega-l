<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 17.10.18
 * Time: 13:09
 */

namespace Omega\Repositories;


use Omega\Models\PageSecurityType;

class PageSecurityTypeRepository
{

    private $pageSecurityType;

    public function __construct(PageSecurityType $pageSecurityType) {

        $this->pageSecurityType = $pageSecurityType;
    }

    public function getSecurityTypeByName($name){
        return $this->pageSecurityType->where('name', $name)->first();
    }

    public function getSecurityNone(){
        return $this->getSecurityTypeByName('none');
    }

    public function getSecurityPassword(){
        return $this->getSecurityTypeByName('bypassword');
    }

    public function getSecurityMember(){
        return $this->getSecurityTypeByName('bymember');
    }
}