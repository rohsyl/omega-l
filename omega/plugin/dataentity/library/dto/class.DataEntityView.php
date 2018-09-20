<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 22.05.2018
 * Time: 19:43
 */

namespace Omega\Plugin\Dataentity\Library\DTO;


class DataEntityView extends \Omega\Library\DTO\Entity
{
    public $id;
    public $fkForm;
    public $name = '';
    public $view = '';

    public function __construct()
    {
        parent::__construct('dataentity_views', array('fkForm', 'name', 'view'), 'id');
    }
}