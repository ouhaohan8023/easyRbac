<?php

namespace Ouhaohan8023\EasyRbac\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionTreeResource extends JsonResource
{
    public function __construct($resource, public $showChildren = true)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'title' => $this->title,
            'weigh' => $this->weigh,
            'is_need_right' => $this->is_need_right,
            'is_need_login' => $this->is_need_login,
            'children' => $this->when($this->showChildren, new PermissionTreeCollection($this->children)),
        ];
    }
}
