<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
    //

    public function getNiceName(){
        return prettify_text($this->name);
    }

    public function users(){
        return $this->belongsToMany('Omega\User', 'userrights', 'fkUser', 'fkRight');
    }

    public function groups(){
        return $this->belongsToMany('Omega\Group', 'grouprights', 'fkGroup', 'fkRight');
    }
}
