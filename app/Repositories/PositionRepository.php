<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 13:24
 */

namespace Omega\Repositories;

use Omega\Models\Position;

class PositionRepository
{
    private $position;

    public function __construct(Position $position) {
        $this->position = $position;
    }

    public function hasModuleInModuleAreaAndPage($idModuleArea, $idPage){
        //SELECT count(*) FROM %s WHERE fkModuleArea = :fkModuleArea AND (fkPage = :fkPage OR fkPage = 0 OR fkPage IS NULL)
        return $this->position->where('fkModuleArea', $idModuleArea)->where(function($query) use($idPage) {
            $query->where('fkpage', $idPage);
            $query->orWhere('fkPage', 0);
            $query->orWhereNull('fkPage');
        })->count() > 0;
    }
}