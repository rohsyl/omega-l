<?php
namespace Omega\Plugin\Portfolio\Library\DTO;

use Omega\Library\DTO\Entity;

class PortfolioSliderItem extends Entity {

    public $id;
    public $fkPortfolioItem;
    public $fkMedia;

    public function __construct() {
        parent::__construct('pf_slideritem', array('fkPortfolioItem', 'fkMedia'), 'id');
    }
}