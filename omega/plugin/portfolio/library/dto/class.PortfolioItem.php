<?php
namespace Omega\Plugin\Portfolio\Library\DTO;

use Omega\Library\DTO\Entity;

class PortfolioItem extends Entity {

    public $id;
    public $fkCategory;
    public $place;
    public $dateItem;
    public $name;
    public $hat;
    public $text;
    public $imageThumbnail;
    public $orderItem;
    public $dateCreated;

    public $category;
    public $image;
    public $slides;
    public $properties;

    public function __construct() {
        parent::__construct('pf_item', array('fkCategory', 'place', 'dateItem', 'name', 'hat', 'text', 'imageThumbnail', 'orderItem', 'dateCreated'), 'id');
    }
}

