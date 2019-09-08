<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Omega\Utils\Entity\Page as PageHelper;

class Page extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function owner(){
        return $this->belongsTo('Omega\Models\User', 'fkUser', 'id');
    }

    public function parent(){
        return $this->belongsTo('Omega\Models\Page', 'fkPageParent', 'id');
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

    public function getCorrespondingPagesAttribute() {
        $corr = array();
        foreach (Lang::all() as $l){
            if($l->slug != $this->lang){
                $corr[$l->slug] = PageHelper::GetCorrespondingInLang($this->id, $l->slug);
            }
        }
        return $corr;
    }

    public function getCorrespondingParentsAttribute() {
        $corr = array();
        foreach (Lang::all() as $l){
            if($l->slug != $this->lang){
                $query = Page::where('lang', $l->slug);
                if($this->fkPageParent == null || $this->fkPageParent == 0){
                    $query = $query->whereNull('fkPageParent');
                }
                else{
                    $query = $query->where('fkPageParent', $this->fkPageParent);
                }
                $corr[$l->slug] = $query->orderBy('order')->get();
            }
        }
        return $corr;
    }
}
