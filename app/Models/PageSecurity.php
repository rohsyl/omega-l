<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class PageSecurity extends Model
{
    //
    public $timestamps = false;

    public function pages(){
        return $this->hasMany('Omega\Models\Page', 'fkPage', 'id');
    }

    public function type(){
        return $this->belongsTo('Omega\Models\PageSecurityType', 'fkType', 'id');
    }
}
