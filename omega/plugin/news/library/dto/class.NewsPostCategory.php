<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 11:03
 */

namespace Omega\Plugin\News\Library\DTO;


use Omega\Library\DTO\Entity;

class NewsPostCategory  extends Entity
{
    public $fkPost;
    public $fkCategory;

    public function __construct()
    {
        parent::__construct('news_post_category', array('fkPost', 'fkCategory'), null);
    }
}