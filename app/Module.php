<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

    public function plugin(){
        return $this->belongsTo('Omega\Plugin', 'fkPlugin', 'id');
    }

    public function page(){
        return $this->belongsTo('Omega\Page', 'fkPage', 'id');
    }
}
