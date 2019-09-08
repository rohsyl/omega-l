<?php

namespace Omega\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PluginMetaResource extends JsonResource
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
            'name' => $this->getName(),
            'version' => $this->getVersion(),
            'author' => $this->getAuthor(),
            'description' => $this->getDescription(),
            'title' => $this->getTitle(),
            'options' => $this->getOptions(),
        ];
    }
}
