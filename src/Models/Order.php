<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Models;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mortezaa97\Addresses\Models\Address;
use Mortezaa97\Coupons\Models\Coupon;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['total_count', 'send_price', 'tax_price', 'payable_price', 'total_price'];

    protected $with = ['products'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });
        static::creating(function ($item) {
            $item->code = mt_rand(100000, 999999);
        });

        //        static::observe(OrderObserver::class);
    }

    public function getTotalCountAttribute()
    {
        return $this->products->sum('count');
    }

    public function getSendPriceAttribute()
    {
        return 1000;
    }

    public function getTaxPriceAttribute()
    {
        return 1000;
    }

    public function getTotalPriceAttribute()
    {
        return $this->products->sum(function ($item) {
            return $item->price * $item->count;
        });
    }

    public function getPayablePriceAttribute()
    {
        return $this->total_price + $this->tax_price + $this->send_price;
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

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function sendType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SendType::class, 'send_type_id');
    }

    public function payType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PayType::class, 'pay_type_id');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Payment::class, 'model');
    }

    public function coupon(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeUnread($query)
    {
        return $query
            ->whereNull('read_by')
            ->whereNull('read_at');
    }
}
