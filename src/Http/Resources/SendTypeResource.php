<?php

namespace Mortezaa97\Orders\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SendTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['title' => $this->title,
            'desc' => $this->desc,
            'logo' => $this->logo ? url($this->logo) : null,
            'default_price' => $this->default_price,
        ];
    }
}
