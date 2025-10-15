<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Resources;

use App\Enums\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'storage_id' => $this->storage_id,
            'status' => Status::from((int) $this->status)?->label(),
            'address_id' => $this->address_id,
            'coupon' => $this->coupon,
            'desc' => $this->desc,
            'discount_price' => $this->discount_price,
            'total_count' => $this->total_count,
            'send_price' => $this->send_price,
            'tax_price' => $this->tax_price,
            'payable_price' => $this->payable_price,
            'total_price' => $this->total_price,
            'send_type' => $this->sendType,
            'pay_type' => $this->payType,
            'products' => CartProductResource::collection($this->products->load('product.parent', 'product.reviews', 'product.attributeProducts')),
        ];
    }
}
