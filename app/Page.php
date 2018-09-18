<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //


    public function owner(){
        return $this->belongsTo('Omega\User', 'fkUser', 'id');
    }

    public function children(){
        return $this->hasMany('Omega\Page', 'fkPageParent', 'id');
    }
}
