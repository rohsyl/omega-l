<?php
namespace Omega\Repositories;


use Omega\Mediameta;

class MediametaRepository{

    private $mediameta;

    public function __construct(Mediameta $mediameta) {

        $this->mediameta = $mediameta;
    }

    public function GetAllForMedia($idMedia){
        return $this->mediameta->where('fkMedia', $idMedia)->get();
    }
}