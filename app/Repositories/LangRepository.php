<?php
namespace Omega\Repositories;

use Omega\Models\Lang;

class LangRepository{

    private $lang;

    public function __construct(Lang $lang) {

        $this->lang = $lang;
    }


    public function all(){
        return $this->lang->all();
    }

    public function allEnabled(){
        return $this->lang->where('isEnabled', true)->get();
    }

}