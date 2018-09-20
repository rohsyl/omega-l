<?php
namespace Omega\Plugin\Dataentity;

use Omega\Library\Plugin\FController;
use Omega\Library\Util\Util;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityDataManager;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityLayoutManager;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityViewManager;
use Omega\Plugin\Dataentity\Library\BLL\EntityManager;
use Omega\Plugin\Dataentity\Library\BLL\PropertyManager;
use Omega\Plugin\Dataentity\Library\DataentityUtil;
use Omega\Plugin\Dataentity\Library\Form\DataEntityType;


class FControllerDataentity extends  FController {


    public function __construct() {
        parent::__construct('dataentity');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
            ),
            'js' => array(
            )
        );
    }

    public function display( $args, $data ) {
        $rawEntities = isset($data['entities']) ? $data['entities'] : array();
        $title = isset($data['title']) ? $data['title'] : '';
        $layoutId = isset($data['layout']) ? $data['layout']['value'] : 0;

        $entities = '';
        foreach($rawEntities as $rawEntity){
            // Get raw data
            $d = DataEntityDataManager::GetData($rawEntity['id']);

            // Get view by id or default
            $viewId = isset($rawEntity['view']) && !empty($rawEntity['view']) && $rawEntity['view'] != 'undefined' ? $rawEntity['view'] : null;
            $view = DataEntityViewManager::GetViewOrFirstForEntity($viewId, $d->fkForm);

            // Get the entity of the raw data
            $entity = EntityManager::GetEntity($d->fkForm);

            // Convert raw data into real object value among the corresponding types
            $values = DataEntityType::GetValues($entity->name, $d->id);

            // Find all property of the entity
            $properties = PropertyManager::GetAllPropertiesOfEntity($entity->id);

            // Create an array of key value with the key is the name of the property and the value is object value of the data
            $out = array();
            foreach($properties as $property){
                $out[$property->name] = $values[$property->id];
            }

            // Render the view as HTML
            $html = DataentityUtil::EvalView($view, $out);


            $entities .= $html;
        }

        $content = $entities;
        if($layoutId != 0){
            $layout = DataEntityLayoutManager::GetLayout($layoutId);

            $content = DataentityUtil::EvalView($layout);

            $content = str_replace(DataentityUtil::GetContentLayoutPlaceHolder(), $entities, $content);
            $content = str_replace(DataentityUtil::GetTitleLayoutPlaceHolder(), $title, $content);
        }
        else{
            $content = '<h3>' . $title . '</h3>' . $content;
        }

        $data['content'] = $content;
        return $this->view( $data );
    }
}