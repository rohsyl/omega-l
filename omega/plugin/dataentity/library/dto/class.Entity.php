<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 16.05.2018
 * Time: 08:28
 */

namespace Omega\Plugin\Dataentity\Library\DTO;


class Entity extends \Omega\Library\DTO\Entity
{
    public $id;
    public $fkPlugin;
    public $name;
    public $title;
    public $isModule = false;
    public $isComponent = false;

    public function __construct()
    {
        parent::__construct('om_form', array('fkPlugin', 'name', 'title', 'isModule', 'isComponent'), 'id');
    }
}

