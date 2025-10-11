<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // ستون اصلی - اطلاعات سفارش (8 ستون)
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    // اطلاعات پایه سفارش
                    \Filament\Schemas\Components\Section::make('اطلاعات پایه سفارش')
                        ->description('اطلاعات اصلی و شناسه‌های سفارش')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            \App\Filament\Components\Form\CodeTextInput::create()
                                ->required()
                                ->columnSpan(6),
                            \App\Filament\Components\Form\UserSelect::create()
                                ->required()
                                ->columnSpan(6),
                            \App\Filament\Components\Form\StatusSelect::create(\Mortezaa97\Orders\Models\Order::class)
                                ->required()
                                ->columnSpan(6),
                            \App\Filament\Components\Form\AddressTextInput::create()
                                ->required()
                                ->columnSpan(6),
                            \App\Filament\Components\Form\DescTextarea::create()
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12)
                        ->collapsible(),

                    // اطلاعات قیمت و پرداخت
                    \Filament\Schemas\Components\Section::make('قیمت و پرداخت')
                        ->description('جزئیات قیمت‌گذاری و روش پرداخت')
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            \App\Filament\Components\Form\DeliveryPriceTextInput::create()
                                ->required()
                                ->columnSpan(4),
                            \App\Filament\Components\Form\CouponPriceTextInput::create()
                                ->required()
                                ->columnSpan(4),
                            \App\Filament\Components\Form\TotalPriceTextInput::create()
                                ->required()
                                ->columnSpan(4),
                            \Filament\Forms\Components\TextInput::make('payment_id')
                                ->label('شناسه پرداخت')
                                ->columnSpan(12),
                            \App\Filament\Components\Form\CouponSelect::create()
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12)
                        ->collapsible(),

                    // اطلاعات ارسال و پیگیری
                    \Filament\Schemas\Components\Section::make('ارسال و پیگیری')
                        ->description('روش ارسال و کدهای پیگیری')
                        ->icon('heroicon-o-truck')
                        ->schema([
                            \Filament\Forms\Components\Select::make('send_type_id')
                                ->label('نوع ارسال')
                                ->relationship('sendType', 'title')
                                ->searchable()
                                ->preload()
                                ->columnSpan(6),
                            \Filament\Forms\Components\Select::make('pay_type_id')
                                ->label('نوع پرداخت')
                                ->relationship('payType', 'title')
                                ->searchable()
                                ->preload()
                                ->columnSpan(6),
                            \App\Filament\Components\Form\TrackingCodeTextInput::create()
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12)
                        ->collapsible(),

                    // محصولات سفارش
                    \Filament\Schemas\Components\Section::make('محصولات سفارش')
                        ->description('مدیریت محصولات و تنوع‌های سفارش')
                        ->icon('heroicon-o-shopping-cart')
                        ->schema([
                            \App\Filament\Components\Form\VariationsRepeater::create()
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12)
                        ->collapsible(),
                ])
                ->columns(12)
                ->columnSpan(8),

            // ستون فرعی - اطلاعات مدیریتی و اضافی (4 ستون)
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    // اطلاعات مدیریتی
                    \Filament\Schemas\Components\Section::make('اطلاعات مدیریتی')
                        ->description('اطلاعات مربوط به مدیریت و ویرایش')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            \App\Filament\Components\Form\CreatedBySelect::create()
                                ->required()
                                ->columnSpan(12),
                            \App\Filament\Components\Form\UpdatedBySelect::create()
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12)
                        ->collapsible(),

                    // اطلاعات اضافی
                    \Filament\Schemas\Components\Section::make('اطلاعات اضافی')
                        ->description('اطلاعات تکمیلی و یادداشت‌ها')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('order_summary')
                                ->label('خلاصه سفارش')
                                ->content('اطلاعات سفارش در اینجا نمایش داده می‌شود')
                                ->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12)
                        ->collapsible()
                        ->collapsed(),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}
