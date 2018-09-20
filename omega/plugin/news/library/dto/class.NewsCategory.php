<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 10:21
 */

namespace Omega\Plugin\News\Library\DTO;


use Omega\Library\DTO\Entity;

class NewsCategory  extends Entity
{
    public $id;
    public $name;
    public $slug;

    public function __construct() {
        parent::__construct('news_category', array('name', 'slug'), 'id');
    }
}