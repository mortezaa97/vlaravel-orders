<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mortezaa97\Addresses\Models\Address;
use Mortezaa97\Coupons\Models\Coupon;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['total_count', 'send_price', 'tax_price', 'payable_price', 'total_price', 'discount_price'];

    protected $with = ['products'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });

        static::creating(function ($item) {
            $item->storage_id = Str::random(15);
        });
    }

    public function getTotalCountAttribute()
    {
        return $this->variations()->sum('count');
    }

    public function getSendPriceAttribute()
    {
        // TODO: make 4000000 dynamic
        return $this->total_price > 4000000 ? 0 : $this->sendType()->first()?->default_price ?? 0;
    }

    public function getTaxPriceAttribute()
    {
        return 0;
    }

    public function getTotalPriceAttribute()
    {
        return $this->variations->sum(function ($item) {
            return $item->price * $item->count;
        });
    }

    public function getPayablePriceAttribute()
    {
        return ($this->total_price + $this->tax_price + $this->send_price) - $this->discount_price;
    }

    public function getDiscountPriceAttribute()
    {
        if (! $this?->coupon) {
            return null;
        } elseif ($this?->coupon->percentage) {
            $amount = $this->total_price * ($this?->coupon->percentage / 100);
            if ($this?->coupon->max_percentage_amount > $amount) {
                return $amount;
            } else {
                return $this?->coupon->max_percentage_amount;
            }
        } else {
            return $this?->coupon->amount;
        }
    }

    /*
    * Relations
    */
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(ModelHasProduct::class, 'model');
    }

    public function coupon(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function sendType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SendType::class, 'send_type_id');
    }

    public function payType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PayType::class, 'pay_type_id');
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
