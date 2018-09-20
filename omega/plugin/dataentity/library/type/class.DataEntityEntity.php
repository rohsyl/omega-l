<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 05.08.2017
 * Time: 19:12
 */

namespace Omega\Plugin\Dataentity\Library\Type;

use Omega\Library\Plugin\ATypeEntry;
use Omega\Library\Util\Path;
use Omega\Library\Util\Util;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityDataManager;
use Omega\Plugin\Dataentity\Library\BLL\EntityManager;
use Omega\Plugin\Dataentity\Library\Form\DataEntityType;

class DataEntityEntity extends ATypeEntry {

    private $param = null;
    private $defaults = array(
        'entityName' => null
    );

    private function getParamSpecial() {
        if(!isset($this->param)) {
            $up = $this->getParam();
            $this->param = array_merge($this->defaults, isset($up) ? $up : array());
        }
        return $this->param;
    }

    public function getHtml()
    {
        $param = $this->getParamSpecial();
        $objValue = $this->getObjectValue();
        $textValue = '';
        if(isset($objValue['data'])){
            foreach($objValue['data'] as $v){
                $textValue .= $v . ' ';
            }
        }
        $idValue = '';
        if(isset($objValue['id'])){
            $idValue = $objValue['id'];
        }

        $m['entity'] = EntityManager::GetEntityByName($param['entityName']);
        $m['uid'] = $this->getUniqId();
        $m['value'] = $idValue;
        $m['text'] = $textValue;
        return $this->view('entity-display', $m, Path::Combine(PLUGINPATH, 'dataentity', 'library', 'type', 'view'));
    }

    public function getPostedValue()
    {
        return $this->getPost($this->getUniqId());
    }

    public  function getObjectValue() {
        $v = $this->getValue();
        if(!isset($v) || empty($v)){
            return array();
        }
        $rawData = DataEntityDataManager::GetData($v);
        $entity = EntityManager::GetEntity($rawData->fkForm);
        $entityValue = DataEntityType::GetValuesHeadingOnly($entity->name, $rawData->id);
        return array(
            'id' => $v,
            'data' => $entityValue
        );
    }

    public function getDoc(){
        return 'No doc';
    }
}