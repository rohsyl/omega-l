<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //


    public function membergroup(){
        return $this->belongsTo('Omega\Membergroup', 'fkMemberGroup', 'id');
    }

}
