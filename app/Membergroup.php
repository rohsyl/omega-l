<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class Membergroup extends Model
{
    public function menus(){
        return $this->hasMany('Omega\Menu', 'fkMemberGroup');
    }
}
