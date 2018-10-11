<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{


    public function membergroups(){
        return $this->belongsToMany('Omega\Models\Membergroup', 'membergrouping', 'fkMember', 'fkMemberGroup' );
    }
}
