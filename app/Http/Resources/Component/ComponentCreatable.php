<?php

namespace Omega\Http\Resources\Component;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Omega\Utils\Plugin\Plugin;
use Omega\Utils\Plugin\PluginMeta;
use Omega\Utils\Plugin\Type;

class ComponentCreatable extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isEnabled' => $this->isEnabled,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
