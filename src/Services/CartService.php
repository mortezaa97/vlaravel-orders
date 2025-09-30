<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Models\Cart;
use Mortezaa97\Orders\Models\ModelHasProduct;
use Mortezaa97\Shop\Models\Product;

class CartService
{
    public function updateCart(Cart $cart, $product_id, $count, $price = null)
    {
        try {
            DB::beginTransaction();
            $product = Product::where('id', $product_id)->withTrashed()->firstOrFail();
            if ($product->quantity < $count) {
                throw new Exception('موجودی کالا کافی نیست', 400);
            }

            $modelProduct = ModelHasProduct::updateOrCreate([
                'product_id' => $product->id,
                'model_type' => Cart::class,
                'model_id' => $cart->id,
            ], [
                'count' => $count,
                'price' => $price || $product->on_sale ? $product->sale_price ?? $product->price : $product->price,
            ]);
            if (! $modelProduct->wasRecentlyCreated) {
                if ($count == 0) {
                    $modelProduct->delete();
                }

                $modelProduct->update([
                    'count' => $count,
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function mergeCart(Cart $storageCart, Cart $userCart)
    {
        try {
            DB::beginTransaction();
            foreach ($storageCart->products as $storageVariation) {
                foreach ($userCart->products as $userVariation) {
                    if ($storageVariation->id == $userVariation->id) {
                        $product = Product::where('id', $storageVariation->id)->firstOrFail();
                        $userVariation->update([
                            'model_type' => Cart::class,
                            'model_id' => $userCart->id,
                            'count' => $userVariation->count + $storageVariation->count,
                            'price' => $product->sale_price ?: $product->price,
                        ]);
                        $storageVariation->delete();
                    }
                }
                $storageCart->products()->update([
                    'model_id' => $userCart->id,
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function empty(Cart $cart)
    {
        try {
            DB::beginTransaction();
            $cart->delete();
            DB::commit();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function shipment(Cart $userCart)
    {
        try {
            DB::beginTransaction();
            $weight = 0;
            foreach ($userCart->variations as $variant) {
                $item_weight = $variant?->product?->weight * $variant->count;
                $weight += $item_weight;
            }
            $county = $userCart->address?->county?->tapin_code;
            $province = $userCart->address?->county?->province?->tapin_code;
            if (! $county || ! $province) {
                throw new Exception('شهر یا استان خارج از سرویس است');
            }

            $tapinService = new TapinService;
            $data = $tapinService->check($weight, $county, $province);

            return $data;
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
