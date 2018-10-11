<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
    //

    public function getNiceName(){
        return prettify_text($this->name);
    }

    public function users(){
        return $this->belongsToMany('Omega\Models\User', 'userrights', 'fkUser', 'fkRight');
    }

    public function groups(){
        return $this->belongsToMany('Omega\Models\Group', 'grouprights', 'fkGroup', 'fkRight');
    }
}
