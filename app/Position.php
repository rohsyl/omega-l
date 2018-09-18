<?php

namespace Omega;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function page(){
        return $this->belongsTo('Omega\Page', 'fkPage', 'id');
    }

    public function module(){
        return $this->belongsTo('Omega\Module', 'fkModule', 'id');
    }
}
