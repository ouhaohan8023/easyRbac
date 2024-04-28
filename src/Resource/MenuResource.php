<?php

namespace Ouhaohan8023\EasyRbac\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'path' => $this->path,
            'component' => $this->component,
            'redirect' => $this->redirect,
            'hidden' => $this->hidden,
            'levelHidden' => $this->levelHidden,
            'title' => $this->title,
            'icon' => $this->icon,
            'isCustomSvg' => $this->isCustomSvg,
            'noKeepAlive' => $this->noKeepAlive,
            'noClosable' => $this->noClosable,
            'noColumn' => $this->noColumn,
            'badge' => $this->badge,
            'tabHidden' => $this->tabHidden,
            'activeMenu' => $this->activeMenu,
            'dot' => $this->dot,
            'dynamicNewTab' => $this->dynamicNewTab,
            'breadcrumbHidden' => $this->breadcrumbHidden,
            'fullscreen' => $this->fullscreen,
            'system' => $this->system,
            'weigh' => $this->weigh,
            'img' => $this->img,
            'type' => $this->type,
            'children' => new MenuCollection($this->children),
        ];
    }
}
