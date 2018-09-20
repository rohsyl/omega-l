<?php

namespace Omega\Plugin\Completedemoplugin\Model;

use Omega\Library\Plugin\Type\DropDown\ADropDownModel;
use Omega\Library\Database\Dbs;
use function Omega\Library\__;

class DropDownPage extends ADropDownModel{

    public  function getKeyValueArray() {
        $stmt  = Dbs::select('id', 'pageName')
            ->from('om_page')
            //->where('fkPageParent', '=', $this->getEntry()->getIdPage())
            ->run();

        $keyvalue = array();
        $keyvalue['null'] = __('Choose a page', true);
        if($stmt->length() > 0){
            foreach($stmt->getAllArray() as $row){
                $keyvalue[$row['id']] = $row['pageName'];
            }
        }
        return $keyvalue;
    }
}