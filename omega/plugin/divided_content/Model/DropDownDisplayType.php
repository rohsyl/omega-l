<?php


namespace OmegaPlugin\DividedContent\Model;


use Omega\Utils\Plugin\Type\DropDown\ADropDownModel;

class DropDownDisplayType extends ADropDownModel
{

    public function getKeyValueArray()
    {
        return [
            '1' => '2 Columns', 
            '2' => '3 Columns', 
            '3' => '4 Columns',
            '4' => 'Tabs', 
            '5' => 'Collapse', 
            '6' => 'Slider',
        ];
    }
}