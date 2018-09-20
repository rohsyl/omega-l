<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 13.06.2018
 * Time: 08:30
 */
namespace Omega\Plugin\Dataentity\Library;

use Omega\Library\Util\Util;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityDataManager;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityViewManager;
use Omega\Plugin\Dataentity\Library\BLL\EntityManager;
use Omega\Plugin\Dataentity\Library\BLL\PropertyManager;
use Omega\Plugin\Dataentity\Library\Form\DataEntityType;

/**
 * Set of method available for views
 * @package Omega\Plugin\Dataentity\Library
 */
class DEUtils{

    /**
     * Render a view for the given entity
     * @param $rawEntity mixed The entity
     * @param $viewName string The name of the view
     */
    public static function RenderView($rawEntity, $viewName){

        $d = DataEntityDataManager::GetData($rawEntity['id']);
        $view = DataEntityViewManager::GetViewByName($viewName);
        $entity = EntityManager::GetEntity($d->fkForm);
        $values = DataEntityType::GetValues($entity->name, $d->id);

        $properties = PropertyManager::GetAllPropertiesOfEntity($entity->id);

        $out = array();
        foreach($properties as $property){
            $out[$property->name] = $values[$property->id];
        }

        if(isset($view)){
            $html = DataentityUtil::EvalView($view, $out);


            $html = '<div class="de-item-'.$d->id.'">' . $html . '</div>';
        }
        else{
            $html = '<div class="alert alert-danger">View "'.$viewName.'" not found for entity '.$entity->title.'</div>';
        }
        echo $html;
    }
}