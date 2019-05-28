<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 28.05.19
 * Time: 20:03
 */

namespace Omega\Utils\Plugin\Form\Renderer;


class BasicFormRenderer extends AFormRenderer
{
    public function render()
    {
        $html = '';
        foreach($this->getEntries() as $entry){
            $html .= $entry->getHtml();
        }
        return $html;
    }
}