<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 28.05.19
 * Time: 20:56
 */

namespace OmegaPlugin\TextAndImage\FormRenderer;


use Omega\Utils\Plugin\Form\Renderer\AFormRenderer;

class TextAndImageFormRenderer extends AFormRenderer
{

    /**
     *
     * @return string
     */
    public function render()
    {
        return plugin_view('text_and_image', 'formrenderer.component')->with([
            'entries' => $this->getEntries()
        ]);
    }
}