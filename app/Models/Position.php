<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function page(){
        return $this->belongsTo('Omega\Models\Page', 'fkPage', 'id');
    }

    public function module(){
        return $this->belongsTo('Omega\Models\Module', 'fkModule', 'id');
    }
}
