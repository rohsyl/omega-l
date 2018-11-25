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

    public function get($id){
        return $this->position->find($id);
    }

    public function hasModuleInModuleAreaAndPage($idModuleArea, $idPage){
        //SELECT count(*) FROM %s WHERE fkModuleArea = :fkModuleArea AND (fkPage = :fkPage OR fkPage = 0 OR fkPage IS NULL)
        return $this->position->where('fkModuleArea', $idModuleArea)->where(function($query) use($idPage) {
            $query->where('fkpage', $idPage);
            $query->orWhere('fkPage', 0);
            $query->orWhereNull('fkPage');
        })->count() > 0;
    }

    public function create($moduleArea, $moduleId, $pageId = null){

        $pos = new Position();
        $pos->fkPage = $pageId;
        $pos->fkModule = $moduleId;
        $pos->fkModuleArea = $moduleArea->id;
        $pos->save();
        return $pos;
    }

    public function delete($id){
        $this->position->destroy($id);
    }

    public function setOnAllPages($positionId, $set, $pageId){
        $pos = $this->get($positionId);
        $pos->fkPage = $set ? null : $pageId;
        $pos->save();
        return $pos;
    }

    public function setlang($positionId, $lang){
        $pos = $this->get($positionId);
        $pos->lang = $lang;
        $pos->save();
        return $pos;
    }

    public function updateOrder($positionId, $order, $moduleareaId){
        $pos = $this->get($positionId);
        $pos->order = $order;
        $pos->fkModuleArea = $moduleareaId;
        $pos->save();
        return $pos;
    }
}