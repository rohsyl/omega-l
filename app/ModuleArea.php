<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class ModuleArea extends Model
{

    public function positions(){
        return $this->hasMany('Omega\Position', 'fkModuleArea', 'id');
    }
}
