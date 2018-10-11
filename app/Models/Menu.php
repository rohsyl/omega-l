<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //


    public function membergroup(){
        return $this->belongsTo('Omega\Models\Membergroup', 'fkMemberGroup', 'id');
    }

}
