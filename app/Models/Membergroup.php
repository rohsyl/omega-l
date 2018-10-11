<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Membergroup extends Model
{
    public function menus(){
        return $this->hasMany('Omega\Models\Menu', 'fkMemberGroup');
    }
}
