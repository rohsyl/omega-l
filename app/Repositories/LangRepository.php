<?php
namespace Omega\Repositories;

use Omega\Models\Lang;

class LangRepository{

    private $lang;

    public function __construct(Lang $lang) {

        $this->lang = $lang;
    }

    public function get($id){
        return $this->lang->find($id);
    }
    public function getBySlug($slug){
        return $this->lang->where('slug', $slug)->first();
    }

    public function all(){
        return $this->lang->all();
    }

    public function allEnabled(){
        return $this->lang->where('isEnabled', true)->get();
    }

    public function create($inputs){
        $lang = new Lang();
        $lang->slug = $inputs['slug'];
        return $this->update($lang, $inputs);
    }

    public function update($lang, $inputs){
        $lang->name = $inputs['name'];
        $lang->isEnabled = $inputs['enabled'];
        $lang->fkMediaFlag = $inputs['fkMedia'];
        $lang->save();
        return $lang;
    }

    public function delete($slug){
        return $this->lang->where('slug', $slug)->delete();
    }

    public function isEnabled(){
        return om_config('om_enable_front_langauge');
    }
}