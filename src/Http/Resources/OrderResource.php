<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'address' => $this->address,
            'code' => $this->code,
            'coupon' => $this->coupon,
            'desc' => $this->desc,
            'total_count' => $this->total_count,
            'created_at' => $this->created_at,
            'send_price' => $this->send_price,
            'tax_price' => $this->tax_price,
            'payable_price' => $this->payable_price,
            'total_price' => $this->total_price,
            'sendType' => $this->sendType,
            'payType' => $this->payType,
            'createBy' => $this->createdBy,
            'user' => $this->user,
            'payments' => $this->payments,
            'user_name' => $this->user?->full_name,
            'user_cellphone' => $this->user?->cellphone,
            'tracking_code' => $this->tracking_code,
            'products' => CartProductResource::collection($this->products),
        ];
    }
}
