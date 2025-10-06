<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Services;

use App\Enums\Status;
use Exception;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Addresses\Models\Address;
use Mortezaa97\Orders\Models\Cart;
use Mortezaa97\Orders\Models\Order;

class OrderService
{
    public function createOrderFromCart(Cart $cart)
    {
        try {
            DB::beginTransaction();
            $data = [
                // required
                'user_id' => $cart->created_by,
                'address_id' => $cart->address_id ? $cart->address_id : Address::where('title', 'ویانا سیستم')->first()->id,
                'delivery_price' => $cart->send_price,
                'coupon_price' => 0,
                'total_price' => $cart->payable_price,
                'created_by' => $cart->created_by,
                'coupon_id' => $cart->coupon_id ? $cart->coupon_id : null, // @todo check if coupon is valid
                'send_type_id' => $cart->send_type_id ? $cart->send_type_id : null,
                'pay_type_id' => $cart->pay_type_id ? $cart->pay_type_id : null,
            ];
            $data['status'] = Status::PENDING->value;
            $order = Order::create($data);
            $order->products()->createMany($cart->products()->get()->toArray());
            DB::commit();

            return $order;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
