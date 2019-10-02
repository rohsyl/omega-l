<?php

namespace Omega\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Omega\Facades\Theme;
use Omega\Models\Page;

class PageEditResource extends JsonResource
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
            'corresponding_pages' => $this->corresponding_pages,
            'corresponding_parents' => $this->corresponding_parents,

            'components' => ComponentFormResource::collection($this->components),
            'modules' => ModuleResource::collection($this->modulesonly),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'config' => [
                'languageEnabled' => om_config('om_enable_front_langauge'),
                'parents' => Page::where('id', '!=', $this->id)->get(),

                'templates' => Theme::templates(),
                'styles' => Theme::styles(),
            ]
        ];
    }
}
