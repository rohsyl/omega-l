<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 17.10.18
 * Time: 13:08
 */

namespace Omega\Repositories;


use Omega\Models\PageSecurity;

class PageSecurityRepository
{
    private $pageSecurity;

    public function __construct(PageSecurity $pageSecurity) {
        $this->pageSecurity = $pageSecurity;
    }

    public function newInstanceOfType($security_type, $pageId){
        $ps = new PageSecurity();
        $ps->fkType = $security_type->id;
        $ps->fkPage = $pageId;
        $ps->data = null;
        $ps->save();
        return $ps;
    }

    public function update($security, $type, $data = null){
        $security->fkType = $type->id;
        $security->data = serialize($data);
        $security->save();
    }
}