<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    public function getNiceName(){
        return prettify_text($this->name);
    }

    public function users(){
        return $this->belongsToMany('Omega\Models\User', 'usergroups', 'fkGroup', 'fkUser' );
    }

    public function rights(){
        return $this->belongsToMany('Omega\Models\Right', 'grouprights', 'fkGroup', 'fkRight');
    }

}
