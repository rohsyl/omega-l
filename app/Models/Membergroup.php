<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Membergroup extends Model
{
    public function menus(){
        return $this->hasMany('Omega\Models\Menu', 'fkMemberGroup');
    }


    public function members(){
        return $this->belongsToMany('Omega\Models\Member', 'membergrouping', 'fkMemberGroup', 'fkMember' );
    }
}
