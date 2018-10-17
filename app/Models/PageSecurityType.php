<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class PageSecurityType extends Model
{
    //
    public $timestamps = false;

    public function securities(){
        return $this->hasMany('Omega\Models\PageSecurity', 'fkType', 'id');
    }
}
