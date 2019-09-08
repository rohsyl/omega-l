<?php

namespace Omega\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Omega\Utils\Plugin\Plugin;
use Omega\Utils\Plugin\PluginMeta;
use Omega\Utils\Plugin\Type;

class ComponentFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $formRenderer = Plugin::Call($this->plugin->name, 'getFormRendererComponent');

        return [
            'id' => $this->id,
            'pluginMeta' => new PluginMetaResource(new PluginMeta($this->plugin->name)),
            'html' => Type::FormRender($this->plugin->id, $this->id, $this->fkPage, $formRenderer),
            'args' => json_decode($this->param, true)
        ];
    }
}
