<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\PaymentSimpleResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Mortezaa97\Addresses\Http\Resources\AddressResource;

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
            'status' => Status::from((int) $this->status)?->label(),
            'address' => AddressResource::make($this->whenLoaded('address')),
            'code' => $this->code,
            'coupon' => $this->coupon,
            'desc' => $this->desc,
            'total_count' => $this->total_count,
            'created_at' => $this->created_at,
            'send_price' => $this->send_price,
            'tax_price' => $this->tax_price,
            'payable_price' => $this->payable_price,
            'total_price' => $this->total_price,
            'sendType' => SendTypeResource::make($this->whenLoaded('sendType')),
            'payType' => PayTypeResource::make($this->whenLoaded('payType')),
            'createBy' => UserResource::make($this->whenLoaded('createdBy')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'payments' => PaymentSimpleResource::collection($this->whenLoaded('payments')),
            'user_name' => $this->user?->full_name,
            'user_cellphone' => $this->user?->cellphone,
            'tracking_code' => $this->tracking_code,
            'products' => CartProductResource::collection($this->products),
        ];
    }
}
