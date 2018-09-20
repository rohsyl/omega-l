<?php
namespace Omega\Plugin\Portfolio\Library\DTO;

use Omega\Library\DTO\Entity;

class PortfolioCategory extends Entity {

    public $id;
    public $name;
    public $color;
    public $orderItem;

    public function __construct() {
        parent::__construct('pf_category', array('name', 'color', 'orderItem'), 'id');
    }
}

