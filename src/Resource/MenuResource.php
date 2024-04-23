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
            'title' => $this->title,
            'url' => $this->url,
            'file_path' => $this->file_path,
            'redirection' => $this->redirection,
            'icon' => $this->icon,
            'badge' => $this->badge,
            'dot' => $this->dot,
            'state' => $this->state,
            'levelHidden' => $this->levelHidden,
            'isSvg' => $this->isSvg,
            'noClosable' => $this->noClosable,
            'breadcrumbHidden' => $this->breadcrumbHidden,
            'activeMenu' => $this->activeMenu,
            'system' => $this->system,
            'extend' => $this->extend,
            'weigh' => $this->weigh,
            'dynamicNewTab' => $this->dynamicNewTab,
            'noKeepAlive' => $this->noKeepAlive,
            'hidden' => $this->hidden,
            'img' => $this->img,
            'type' => $this->type,
            'children' => new MenuCollection($this->children),
        ];
    }
}
