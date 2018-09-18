<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class ModuleArea extends Model
{

    public function positions(){
        $this->hasMany('Omega\Position', 'fkModuleArea', 'id');
    }
}
