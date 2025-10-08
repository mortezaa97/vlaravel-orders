<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Traits;

use Mortezaa97\Orders\Models\Cart;
use Mortezaa97\Orders\Models\Order;
use Mortezaa97\Shop\Models\Product;

trait OrderTrait
{
    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            related: Order::class,
            table: 'model_has_products',
            foreignPivotKey: 'product_id',
            relatedPivotKey: 'model_id'
        );
    }
    public function carts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            related: Cart::class,
            table: 'model_has_product',
            foreignPivotKey: 'product_id',
            relatedPivotKey: 'model_id'
        );
    }
}
