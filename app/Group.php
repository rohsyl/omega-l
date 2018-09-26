<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    public function getNiceName(){
        return prettify_text($this->name);
    }

    public function users(){
        return $this->belongsToMany('Omega\User', 'usergroups', 'fkUser', 'fkGroup');
    }

    public function right(){
        return $this->belongsToMany('Omega\Right', 'grouprights', 'fkRight', 'fkGroup');
    }

}
