<?php

namespace Mortezaa97\Orders\Services;

use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Models\Address;
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
                'user_id' => $cart->create_by,
                'address_id' => $cart->address_id ? $cart->address_id : Address::where('title', 'ویانا سیستم')->first()->id,
                'delivery_price' => $cart->send_price,
                'coupon_price' => 0,
                'total_price' => $cart->payable_price,
                'create_by' => $cart->create_by,
                // nullables
                'coupon_id' => $cart->coupon_id ? $cart->coupon_id : null, // @todo check if coupon is valid
                'send_type_id' => $cart->send_type_id ? $cart->send_type_id : null,
                'pay_type_id' => $cart->pay_type_id ? $cart->pay_type_id : null,
            ];
            $order = Order::create($data);
            $order->setStatus('در انتظار پرداخت');

            $variations = $order->variations()->createMany($cart->variations()->get()->toArray());
            DB::commit();

            return $order;

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
