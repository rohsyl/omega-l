<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 22.05.2018
 * Time: 19:43
 */

namespace Omega\Plugin\Dataentity\Library\DTO;


class DataEntityData extends \Omega\Library\DTO\Entity
{
    public $id;
    public $fkForm;
    public $values = '{}';

    public function __construct()
    {
        parent::__construct('dataentity_datas', array('fkForm', 'values'), 'id');
    }
}