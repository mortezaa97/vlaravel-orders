<?php

namespace Mortezaa97\Orders\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \App\Filament\Components\Form\CodeTextInput::create()->required(),
                            \App\Filament\Components\Form\UserSelect::create()->required(),
                            \App\Filament\Components\Form\AddressTextInput::create()->required(),
                            \App\Filament\Components\Form\CouponSelect::create(),
                            \App\Filament\Components\Form\DeliveryPriceTextInput::create()->required(),
                            \App\Filament\Components\Form\CouponPriceTextInput::create()->required(),
                            \App\Filament\Components\Form\TotalPriceTextInput::create()->required(),
                            \App\Filament\Components\Form\PaymentTypeSelect::create()->required(),
                            \Filament\Forms\Components\TextInput::make('payment_id'),
                            \App\Filament\Components\Form\DescTextarea::create(),
                            \App\Filament\Components\Form\TrackingCodeTextInput::create(),
                            \Filament\Forms\Components\Select::make('send_type_id')->relationship('sendType', 'title'),
                            \Filament\Forms\Components\Select::make('pay_type_id')->relationship('payType', 'title'),
                            \App\Filament\Components\Form\CreatedBySelect::create()->required(),
                            \App\Filament\Components\Form\UpdatedBySelect::create(),

                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(8),
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}
