<?php

declare(strict_types=1);

namespace Mortezaa97\Orders;

use App\Enums\Status;
use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Mortezaa97\Orders\Filament\Resources\Carts\CartResource;
use Mortezaa97\Orders\Filament\Resources\Orders\OrderResource;
use Mortezaa97\Orders\Filament\Resources\PayTypes\PayTypeResource;
use Mortezaa97\Orders\Filament\Resources\SendTypes\SendTypeResource;
use Mortezaa97\Orders\Models\Order;

class OrdersPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'order';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                'CartResource' => CartResource::class,
                'PayTypeResource' => PayTypeResource::class,
                'SendTypeResource' => SendTypeResource::class,
                'OrderResource'  => OrderResource::class
            ])->navigationItems([
                NavigationItem::make('بررسی نشده ها')
                    ->url(fn () => OrderResource::getUrl('index', ['filters[status][value]' => Status::PENDING]))
                    ->icon('heroicon-o-rectangle-stack')
                    ->group('امور سفارشات')
                    ->sort(1)
                    ->isActiveWhen(fn () => request()->fullUrlIs(OrderResource::getUrl('index', ['filters[status][value]' => Status::PENDING], true) . '*')),

                NavigationItem::make('تکمیل شده ها')
                    ->url(fn () => OrderResource::getUrl('index', ['filters[status][value]' => Status::COMPLETED]))
                    ->icon('heroicon-o-rectangle-stack')
                    ->group('امور سفارشات')
                    ->sort(1)
                    ->isActiveWhen(fn () => request()->fullUrlIs(OrderResource::getUrl('index', ['filters[status][value]' => Status::COMPLETED], true) . '*')),

            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
