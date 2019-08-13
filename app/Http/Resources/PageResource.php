<?php

namespace Omega\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fkMenu' => $this->fkMenu,
            'fkPageParent' => $this->fkPageParent,
            'fkUser' => $this->fkUser,
            'lang' => $this->lang,
            'slug' => $this->slug,
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'showName' => $this->showName,
            'showSubtitle' => $this->showSubtitle,
            'isEnabled' => $this->isEnabled,
            'cssTheme' => $this->cssTheme,
            'keyWords' => $this->keyWords,
            'model' => $this->model,
            'order' => $this->order,

            'components' => [],
            'modules' => [],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
