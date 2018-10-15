<?php
namespace Omega\Repositories;


use Omega\Models\MediaMeta;

class MediametaRepository{

    private $mediameta;

    public function __construct(MediaMeta $mediameta) {

        $this->mediameta = $mediameta;
    }

    public function GetAllForMedia($idMedia){
        return $this->mediameta->where('fkMedia', $idMedia)->get();
    }
}