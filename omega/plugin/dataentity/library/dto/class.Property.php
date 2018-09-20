<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 16.05.2018
 * Time: 09:24
 */

namespace Omega\Plugin\Dataentity\Library\DTO;


class Property extends \Omega\Library\DTO\Entity
{
    public $id;
    public $fkForm;
    public $name = '';
    public $type = '';
    public $param = '';
    public $title = '';
    public $description = '';
    public $mandatory = false;
    public $heading = false;
    public $order = 0;

    public function __construct()
    {
        parent::__construct('om_form_entry', array('fkForm', 'name', 'type', 'param', 'title', 'description', 'mandatory', 'heading', 'order'), 'id');
    }
}