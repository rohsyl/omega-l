<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function owner(){
        return $this->belongsTo('Omega\Models\User', 'fkUser', 'id');
    }

    public function children(){
        return $this->hasMany('Omega\Models\Page', 'fkPageParent', 'id');
    }

    public function modules(){
        return $this->hasMany('Omega\Models\Module', 'fkPage', 'id');
    }

    public function modulesonly(){
        return $this->modules()->where('isComponent', 0);
    }

    public function components(){
        return $this->modules()->where('isComponent', 1);
    }

    public function security(){
        return $this->hasOne('Omega\Models\PageSecurity', 'fkPage', 'id');
    }
}
