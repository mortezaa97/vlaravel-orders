<?php

namespace Mortezaa97\Orders\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mortezaa97\Orders\Http\Resources\ProductResource;
use Mortezaa97\Shop\Http\Resources\ProductSimpleResource;

class CartProductResource extends JsonResource
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
            'count' => $this->count,
            'price' => $this->price,
            'total_price' => $this->total,
            'rate' => $this->product?->parent?->rate,
            'name' => $this->product?->parent?->name,
            'english_name' => $this->product?->parent?->english_name,
            'image' => url($this->product?->parent?->image),
            'slug' => $this->product?->parent?->slug,
            'code' => $this->product?->parent?->code,
            'product' => new ProductSimpleResource($this->product),
        ];
    }
}
