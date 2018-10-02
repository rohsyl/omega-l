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
        return $this->belongsToMany('Omega\User', 'usergroups', 'fkGroup', 'fkUser' );
    }

    public function rights(){
        return $this->belongsToMany('Omega\Right', 'grouprights', 'fkGroup', 'fkRight');
    }

}
