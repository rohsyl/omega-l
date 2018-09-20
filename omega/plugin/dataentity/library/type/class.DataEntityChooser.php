<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 13.06.2018
 * Time: 08:43
 */

namespace Omega\Plugin\Dataentity\Library\Type;


use Omega\Library\Plugin\ATypeEntry;
use Omega\Library\Util\Path;
use Omega\Library\Util\Util;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityDataManager;
use Omega\Plugin\Dataentity\Library\BLL\EntityManager;
use Omega\Plugin\Dataentity\Library\Form\DataEntityType;

class DataEntityChooser extends ATypeEntry
{

    public function getHtml()
    {
        $m = array();
        $m['uid'] = $this->getUniqId();
        $m['value'] = urlencode($this->getValue());
        $m['objdata'] = $this->getObjectValueWithData();
        return $this->view('entity-chooser', $m, Path::Combine(PLUGINPATH, 'dataentity', 'library', 'type', 'view'));
    }

    private function getObjectValueWithData(){
        $values = $this->getObjectValue();
        $instances = array();
        foreach($values as $val){
            $item = array();
            $data = DataEntityDataManager::GetData($val['id']);
            $entity = EntityManager::GetEntity($data->fkForm);

            $dataValue = DataEntityType::GetValuesHeadingOnly($entity->name, $data->id);
            $item['id'] = $data->id;
            $item['view'] = isset($val['view']) ? $val['view'] : 'undefined';
            $item['title'] = implode(', ', $dataValue);
            $item['entityTitle'] = $entity->title;
            $instances[] = $item;
        }
        return $instances;
    }

    public function getPostedValue()
    {
        return urldecode($this->getPost($this->getUniqId()));
    }

    public function getObjectValue()
    {
        $v = $this->getValue();
        $json = isset($v) && !empty($v) ? $v : '{}';
        $values = json_decode($json, true);
        return $values;
    }

    public function getDoc()
    {
        return 'No doc';
    }
}