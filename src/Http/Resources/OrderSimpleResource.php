<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderSimpleResource extends JsonResource
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
            'code' => $this->code,
            'desc' => $this->desc,
            'total_count' => $this->total_count,
            'created_at' => $this->created_at,
            'send_price' => $this->send_price,
            'tax_price' => $this->tax_price,
            'payable_price' => $this->payable_price,
            'total_price' => $this->total_price,
            'sendType' => $this->sendType,
            'payType' => $this->payType,
            'tracking_code' => $this->tracking_code,
        ];
    }
}
