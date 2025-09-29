<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Models\Cart;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fa_IR');

        $userIds = User::role('user')->pluck('id');
        $couponIds = DB::table('coupons')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        $cartStatuses = [Status::PENDING, Status::PROCESSING, Status::CANCELLED, Status::COMPLETED];

        for ($i = 0; $i < 10; $i++) {
            $userId = ! empty($userIds) ? $faker->randomElement($userIds) : 2;
            $addressId = ! empty($addressIds) ? $faker->randomElement($addressIds) : 1;
            $couponId = ! empty($couponIds) ? $faker->randomElement($couponIds) : null;
            $addressIds = DB::table('addresses')->where('created_by', $userId)->pluck('id')->toArray();

            $cartData = [
                'storage_id' => $faker->shuffleString,
                'status' => $faker->randomElement($cartStatuses),
                'address_id' => $addressId,
                'ip' => $faker->ipv4,
                'desc' => $faker->realText(),
                'coupon_id' => $couponId,
                'created_by' => $userId,
            ];

            $cart = Cart::create($cartData); // Assuming Cart model namespace

            $productItems = [];
            $numProducts = $faker->numberBetween(1, 4);
            for ($j = 0; $j < $numProducts; $j++) {
                $productId = ! empty($productIds) ? $faker->randomElement($productIds) : 1;
                $productItems[] = [
                    'model_type' => Cart::class, // Adjust namespace if needed
                    'model_id' => $cart->id,
                    'product_id' => $productId,
                    'price' => $faker->randomFloat(0, 2, 100000, 1000000), // e.g., in toman
                    'count' => $faker->numberBetween(1, 10),
                    'desc' => $faker->optional(0.7)->realText(50),
                    'created_by' => $userId,
                    'created_at' => now(),
                ];
            }

            DB::table('model_has_products')->insert($productItems);
        }
    }
}
