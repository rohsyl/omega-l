<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.07.2018
 * Time: 14:23
 */

namespace Omega\Plugin\Dataentity\Library\Type\Model;


use Omega\Library\Plugin\Type\DropDown\ADropDownModel;
use Omega\Plugin\Dataentity\Library\BLL\DataEntityLayoutManager;
use function Omega\Library\__;

class LayoutDropDownModel extends ADropDownModel
{
    public  function getKeyValueArray()
    {
        $layouts = DataEntityLayoutManager::GetAllLayouts();
        $kvArray = array();

        $kvArray[0] = __('No layout', true);
        foreach($layouts as $l){
            $kvArray[$l->id] = $l->name;
        }

        return $kvArray;
    }
}

/*
 * JSON param
{"model" : "Omega\\\\Plugin\\\\Dataentity\\\\Library\\\\Type\\\\Model\\\\LayoutDropDownModel"}
*/