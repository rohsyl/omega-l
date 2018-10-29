<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
