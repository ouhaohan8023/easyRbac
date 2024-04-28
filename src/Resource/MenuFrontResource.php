<?php

namespace Ouhaohan8023\EasyRbac\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuFrontResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'component' => $this->component,
            'redirect' => $this->redirect,
            'meta' => [
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
                'breadcrumbHidden' => $this->breadcrumbHidden,
                'dynamicNewTab' => $this->dynamicNewTab,
                'fullscreen' => $this->fullscreen,
            ],
            'children' => new MenuFrontCollection($this->children),
        ];
    }
}
