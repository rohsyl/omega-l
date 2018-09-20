<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.07.2018
 * Time: 13:21
 */

namespace Omega\Plugin\Dataentity\Library\DTO;


class DataEntityLayout extends \Omega\Library\DTO\Entity
{

    public $id;
    public $name = '';
    public $view = '';

    public function __construct()
    {
        parent::__construct('dataentity_layouts', array('name', 'view'), 'id');
    }
}