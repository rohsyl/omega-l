<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //


    public function owner(){
        return $this->belongsTo('Omega\Models\User', 'fkUser', 'id');
    }

    public function children(){
        return $this->hasMany('Omega\Models\Page', 'fkPageParent', 'id');
    }

    public function modules(){
        return $this->hasMany('Omega\Models\Module', 'fkPage', 'id');
    }
}
