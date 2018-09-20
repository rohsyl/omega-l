<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 10:15
 */

namespace Omega\Plugin\News\Library\DTO;


use Omega\Library\DTO\Entity;

class NewsPost extends Entity
{
    public $id;
    public $title;
    public $hat;
    public $idImage;
    public $text;
    public $created;
    public $archived;
    public $fkUser;

    public $categories;
    public $user;

    public function __construct()
    {
        parent::__construct('news_post', array('title', 'hat', 'idImage', 'text', 'created', 'archived', 'fkUser'), 'id');
    }
}
