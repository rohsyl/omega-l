<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    public function plugin(){
        return $this->belongsTo('Omega\Models\Plugin', 'fkPlugin', 'id');
    }

    public function page(){
        return $this->belongsTo('Omega\Models\Page', 'fkPage', 'id');
    }

    public function positions(){
        return $this->hasMany('Omega\Models\Position', 'fkModule', 'id');
    }
}
