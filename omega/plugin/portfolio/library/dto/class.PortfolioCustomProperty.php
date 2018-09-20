<?php
namespace Omega\Plugin\Portfolio\Library\DTO;

use Omega\Library\DTO\Entity;

class PortfolioCustomProperty extends Entity {

    public $id;
    public $name;
    public $title;
    public $useAsFilter;
    public $propOrder;

    public function __construct() {
        parent::__construct('pf_custom_properties', array('name', 'title', 'useAsFilter', 'propOrder'), 'id');
    }
}