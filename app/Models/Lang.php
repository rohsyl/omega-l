<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    public $timestamps = false;

    public function media(){
        return $this->belongsTo('Omega\Models\Media', 'fkMediaFlag');
    }
}
