<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 25.11.18
 * Time: 11:31
 */

namespace OmegaPlugin\Menu\Model;


use Omega\Models\Menu;
use Omega\Repositories\MenuRepository;
use Omega\Utils\Plugin\Type\DropDown;

class DropDownMenu extends DropDown\ADropDownModel
{

    private $menuRepository;

    public function __construct($entry) {
        parent::__construct($entry);
        $this->menuRepository = new MenuRepository(new Menu());
    }


    public function getKeyValueArray() {

    }
}