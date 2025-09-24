<?php

namespace Mortezaa97\Orders\Services;

use Illuminate\Support\Facades\DB;
use Mortezaa97\Orders\Models\Cart;
use Mortezaa97\Orders\Models\ModelProduct;
use Mortezaa97\Orders\Models\Variant;

class CartService
{
    public function updateCart(Cart $cart, $variant_id, $count, $price = null)
    {
        try {
            DB::beginTransaction();
            // AK47: handle using categories not using withTrashed
            $variant = Variant::where('id', $variant_id)->withTrashed()->firstOrFail();
            if ($variant->quantity < $count) {
                throw new \Exception('موجودی کالا کافی نیست', 400);
            }

            $modelProduct = ModelProduct::updateOrCreate([
                'variant_id' => $variant->id,
                'model_type' => Cart::class,
                'model_id' => $cart->id,
            ], [
                'count' => $count,
                'price' => $price || $variant->on_sale ? $variant->sale_price ?? $variant->price : $variant->price,
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
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function mergeCart(Cart $storageCart, Cart $userCart)
    {
        try {
            DB::beginTransaction();
            foreach ($storageCart->variations as $storageVariation) {
                foreach ($userCart->variations as $userVariation) {
                    if ($storageVariation->id == $userVariation->id) {
                        $variant = Variant::where('id', $storageVariation->id)->firstOrFail();
                        $userVariation->update([
                            'model_type' => Cart::class,
                            'model_id' => $userCart->id,
                            'count' => $userVariation->count + $storageVariation->count,
                            'price' => $variant->sale_price ?: $variant->price,
                        ]);
                        $storageVariation->delete();
                    }
                }
                $storageCart->variations()->update([
                    'model_id' => $userCart->id,
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function empty(Cart $cart)
    {
        try {
            DB::beginTransaction();
            $cart->delete();
            DB::commit();
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function shipment(Cart $userCart)
    {
        try {
            DB::beginTransaction();
            $weight = 0;
            foreach ($userCart->variations as $variant) {
                $item_weight = $variant?->variant?->product?->weight * $variant->count;
                $weight += $item_weight;
            }
            $county = $userCart->address?->county?->tapin_code;
            $province = $userCart->address?->county?->province?->tapin_code;
            if (! $county || ! $province) {
                throw new \Exception('شهر یا استان خارج از سرویس است');
            }

            $tapinService = new TapinService;
            $data = $tapinService->check($weight, $county, $province);

            return $data;
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
