<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 29.05.19
 * Time: 15:41
 */

namespace OmegaPlugin\Teaser\FormRenderer;


use Omega\Utils\Plugin\Form\Renderer\AFormRenderer;

class TeaserFormRenderer extends AFormRenderer
{

    /**
     *
     * @return string
     */
    public function render()
    {
        return plugin_view('teaser', 'formrenderer.component')->with([
            'entries' => $this->getEntries()
        ]);
    }
}