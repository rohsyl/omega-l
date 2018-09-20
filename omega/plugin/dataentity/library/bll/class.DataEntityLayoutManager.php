<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 22.05.2018
 * Time: 19:46
 */

namespace Omega\Plugin\Dataentity\Library\BLL;

use Omega\Library\BLL\Manager;
use Omega\Plugin\Dataentity\Library\DAL\DataEntityLayoutDb;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityLayout;

class DataEntityLayoutManager extends Manager
{
    /**
     * Get all layouts
     * @return DataEntityLayout[]|null
     */
    public static function GetAllLayouts(){
        return DataEntityLayoutDb::GetAllLayouts();
    }

    /**
     * Get a layout by id
     * @param $id int The id of the layout
     * @return DataEntityLayout|null The view
     */
    public static function GetLayout($id){
        return DataEntityLayoutDb::GetLayout($id);
    }

    /**
     * Insert or update a dataentitylayout
     * @param $entity DataEntityLayout The layout
     * @return bool True if success
     */
    public static function Save($entity) {
        if($entity->id == null){
            return DataEntityLayoutDb::Insert($entity);
        }
        else {
            return DataEntityLayoutDb::Update($entity);
        }
    }

    /**
     * Delete the layout by id
     * @param $id int The id
     * @return bool True if success
     */
    public static function Delete($id) {
        return DataEntityLayoutDb::Delete($id);
    }
}