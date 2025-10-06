<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Payment;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Models\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fa_IR');

        $userIds = User::role('user')->pluck('id');
        $couponIds = DB::table('coupons')->pluck('id')->toArray();
        $sendTypeIds = DB::table('send_types')->pluck('id')->toArray();
        $payTypeIds = DB::table('pay_types')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $userId = ! empty($userIds) ? $faker->randomElement($userIds) : 2;
            $userAddresses = DB::table('addresses')->where('created_by', $userId)->pluck('id')->toArray();
            $addressId = ! empty($userAddresses) ? $faker->randomElement($userAddresses) : 1;
            $couponId = ! empty($couponIds) ? $faker->randomElement($couponIds) : null;
            $sendTypeId = ! empty($sendTypeIds) ? $faker->randomElement($sendTypeIds) : 1;
            $payTypeId = ! empty($payTypeIds) ? $faker->randomElement($payTypeIds) : 1;

            $numProducts = $faker->numberBetween(1, 4);
            $productItems = [];
            $subtotal = 0;

            for ($j = 0; $j < $numProducts; $j++) {
                $productId = ! empty($productIds) ? $faker->randomElement($productIds) : 1;
                $price = $faker->randomFloat(0, 0, 50000, 500000); // e.g., in toman
                $count = $faker->numberBetween(1, 5);
                $productItems[] = [
                    'model_type' => Order::class,
                    'model_id' => null, // Will be set after order creation
                    'product_id' => $productId,
                    'price' => $price,
                    'count' => $count,
                    'desc' => $faker->optional(0.7)->realText(50),
                    'created_by' => $userId,
                    'updated_by' => $userId,
                    'deleted_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $subtotal += $price * $count;
            }

            $deliveryPrice = $faker->randomFloat(0, 0, 20000, 150000);
            $couponPrice = $couponId ? $faker->randomFloat(0, 0, 0, min($subtotal * 0.5, 100000)) : 0;
            $totalPrice = $subtotal + $deliveryPrice - $couponPrice;

            $orderData = [
                'code' => 'ORD-' . strtoupper($faker->regexify('[A-Z0-9]{6}')),
                'user_id' => $userId,
                'address_id' => $addressId,
                'coupon_id' => $couponId,
                'delivery_price' => $deliveryPrice,
                'coupon_price' => $couponPrice,
                'total_price' => $totalPrice,
                'payment_type' => $faker->randomElement([
                    0, // 'online',1//'pos',2//'credit'
                ]),
                'desc' => $faker->realText(200),
                'tracking_code' => $faker->regexify('[A-Z]{2}\d{9}[A-Z]{2}'),
                'send_type_id' => $sendTypeId,
                'pay_type_id' => $payTypeId,
                'created_by' => $userId,
                'updated_by' => $userId,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $order = Order::create($orderData);

            // Update model_id in product items
            foreach ($productItems as &$item) {
                $item['model_id'] = $order->id;
            }

            DB::table('model_has_products')->insert($productItems);
            $paymentStatuses = [Status::COMPLETED, Status::PENDING, Status::FAILED, Status::CANCELLED];
            // Create payment
            $paymentData = [
                'user_id' => $userId,
                'transaction_id' => $faker->uuid,
                'ref_id' => $faker->randomNumber(8),
                'ref_url' => $faker->url,
                'price' => $totalPrice,
                'token' => $faker->sha1,
                'gateway' => 'zibal',
                'model_type' => Order::class,
                'model_id' => $order->id,
                'status' => $faker->randomElement($paymentStatuses),
                'created_by' => $userId,
                'updated_by' => $userId,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $payment = Payment::create($paymentData);

            // Update order with payment_id
            $order->update(['payment_id' => $payment->id]);
        }
    }
}
