<?php

namespace Ouhaohan8023\EasyRbac\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function __construct($resource, public $showChildren = true)
    {
        parent::__construct($resource);
    }

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
            'state' => $this->state,
            'children' => $this->when($this->showChildren, new RoleCollection($this->children)),
        ];
    }
}
