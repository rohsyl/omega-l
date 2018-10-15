<?php
namespace Omega\Repositories;


use Omega\Models\MediaMeta;

class MediaMetaRepository{

    private $mediameta;

    public function __construct(MediaMeta $mediameta) {

        $this->mediameta = $mediameta;
    }

    public function GetAllForMedia($idMedia){
        return $this->mediameta->where('fkMedia', $idMedia)->get();
    }

    public function getOrNew($id){
        if(isset($id)){
            return $this->mediameta->find($id);
        }
        return new $this->mediameta;
    }
}