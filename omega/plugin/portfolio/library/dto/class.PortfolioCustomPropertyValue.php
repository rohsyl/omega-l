<?php
namespace Omega\Plugin\Portfolio\Library\DTO;

use Omega\Library\DTO\Entity;

class PortfolioCustomPropertyValue extends Entity {

    public $id;
    public $fkItem;
    public $fkCustomProperty;
    public $value;

    public $property;

    public function __construct() {
        parent::__construct('pf_cp_values', array('fkItem', 'fkCustomProperty', 'value'), 'id');
    }
}